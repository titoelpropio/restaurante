var url = "../Controlador/RegistrarCompra_Controlador.php";
var idStock=0;
var padreSession = window.parent.$("#cerrarSession");
$(document).ready(function(){
   $(".fecha").datepicker();
   $(".fecha").val(fechaActual());
   $("input[type=number]").val(0);
   idStock=localStorage.getItem("idstock");
   if(localStorage.getItem("atras")===""){
       $("#atras").ocultar();
   }
    cargando(true);
    $.post(url, {proceso: 'iniciar',stock:idStock}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            var html="<option value='0'>--Seleccione una Sucursal--</option>";
            if(json.sucursal!==null)
            for (var i = 0; i < json.result.sucursal.length; i++) {
                html+="<option value='"+json.result.sucursal[i].id_sucursal+"'>"+json.result.sucursal[i].nombre+"</option>";
            }
            $("#sucursal").html(html);
            $("#sucursal option[value="+json.result.id_sucursal+"]").attr("selected",true);
            html="<option value='0'>--Seleccione una Almacen--</option>";
            if(json.result.almacen!==null)
            for (var i = 0; i < json.result.almacen.length; i++) {
                html+="<option value='"+json.result.almacen[i].id_almacen+"'>"+json.result.almacen[i].nombre+"</option>";
            }
            $("#almacen option[value="+json.result.id_almacen+"]").attr("selected",true);
            $("#almacen").html(html);
            html="<option value='0'>-- Unidad de Medida --</option>";
            if(json.result.unidad!==null)
            for (var i = 0; i < json.result.unidad.length; i++) {
                html+="<option value='"+json.result.unidad[i].Id_Unidad+"'>"+json.result.unidad[i].descripcion+"</option>";
            }
            $("#unidad").html(html);
            if(idStock!=0){
                $("input[name=nombre]").val(json.result.producto.nombre);
                $("input[name=preciocompra]").val(json.result.producto.Precio_Compra);
                $("input[name=precioventa]").val(json.result.producto.Precio_Venta);
                $("input[name=cantmin]").val(json.result.stock.cantidadmin);
                $("#unidad option[value="+json.result.producto.Unidad_Id+"]").attr("selected",true);
                $("#tipo option[value="+json.result.producto.tipo+"]").attr("selected",true);
                $("#sucursal option[value="+json.result.producto.id_sucursal+"]").attr("selected",true);
                $("#almacen option[value="+json.result.producto.id_almacen+"]").attr("selected",true);
                $("#sucursal").attr("disabled",true);
                $("#almacen").attr("disabled",true);
                $("#fotoperfil img").attr("src",json.result.producto.foto);
            }

        }
    });
});
function registroCompra(){
    var nombre=$("input[name=nombre]").val();
    var cantidad=$("input[name=cantidad]").val();
    var precioCompra=$("input[name=preciocompra]").val();
    var precioventa=$("input[name=precioventa]").val();
    var cantmin=$("input[name=cantmin]").val();
    var fecha=$("input[name=fecha]").val();
    var unidad=$("#unidad option:selected").val();
    var tipo=$("#tipo option:selected").val();
    var sucrusal=$("#sucursal option:selected").val();
    var almacen=$("#almacen option:selected").val();
    var foto=$("#fotoperfil img").attr("src");
    var error="";
    if(!validar("texto y entero",nombre)){
        error+="<p>El nombre no es valido. No se aceptan caracteres especiales.</p>";
    }
    if(parseFloat(cantidad)<=0){
        error+="<p>No ha especificado un cantidad valida.</p>";
    }
    if(unidad==="0"){
        error+="<p>Selecciones una unidad de medida.</p>";
    }
    if(parseFloat(precioCompra)<=0){
        error+="<p>No ha especificado el precio compra.</p>";
    }
    if(parseFloat(precioventa)<=0 && tipo!=="Ingredientes"){
        error+="<p>No ha especificado el precio venta.</p>";
    }
    if(parseFloat(cantmin)<=0){
        error+="<p>La cantidad minimo no puede ser menor o igual a 0.</p>";
    }
    if(sucrusal==="0" && almacen==="0"){
        error+="<p>Debe seleccionar el almacen o sucursal donde registrara el producto.</p>";
    }
    if(error!=""){
        $("body").msmOK(error);
        return;
    }
    cargando(true);
    $.post(url, {proceso: 'registarProducto',idstock:idStock,nombre:nombre,cantidad:cantidad,fecha:fecha, fproducto:foto
        ,unidad:unidad,tipo:tipo,venta:precioventa,compra:precioCompra,min:cantmin,sucursal:sucrusal,almacen:almacen}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            $("El producto "+nombre+" se registro correctamente.");
            $("#compraRegistro").limpiarFormulario();
            $("#fotoperfil img").attr("src","../Imagen/food.svg");
        }
    });
}
$(window).resize(function () {
    $("#nuevaunidad").css({
        position: 'fixed',
        left: $(".mas").position().left,
        top: $(".mas").position().top
    });
});
function atras(){
    $(location).attr('href',localStorage.getItem("atras"));
}
function masunida(){
    if($(".mas").text()==="(+)"){
        $(".mas").text("(-)");
        $("#nuevaunidad input").val("");
        $("#nuevaunidad").visible();
        $("#nuevaunidad").centrar();
        $("#nuevaunidad input").focus();
        $("#nuevaunidad").css({
            position: 'fixed',
            left: $(".mas").position().left,
            top: $(".mas").position().top-68
        });
        
    }else{
        $(".mas").text("(+)");
        $("#nuevaunidad").ocultar();
    }
}
function cambiotipo(){
    if("Ingredientes"===$("#tipo option:selected").val()){
        $("input[name=precioventa]").val(0);
        $("input[name=precioventa]").ocultar();
        $("#pventa").ocultar();
    }else{
        $("input[name=precioventa]").visible();
        $("#pventa").visible(1);
    }
}
function crearUnidad(e,ele){
    if(e.keyCode!==13){
        return;
    }
    var text=$(ele).val();
    if(!validar("texto y entero",text)){
        $("body").msmOK("La nueva unidad de medida no puede tener caracteres especiales.");
        return;
    }
    cargando(true);
    $.post(url, {proceso: 'crearUnidad', text: text},function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            var html="<option value='0'>-- Unidad de Medida --</option>";
            if(json.result!==null)
            for (var i = 0; i < json.result.length; i++) {
                html+="<option value='"+json.result[i].id_unidad+"'>"+json.result[i].descripcion+"</option>";
            }
            $("#unidad").html(html);
            $("button").focus();
        }
    });
}


 
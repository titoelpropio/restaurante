var url = "../Controlador/StockBajo_Controlador.php";
var padreSession = window.parent.$("#cerrarSession");
$(document).ready(function(){
   $(".fecha").datepicker();
   $(".fecha").val(fechaActual());
   $("input[type=number]").val(0);
    cargando(true);
    $.post(url, {proceso: 'iniciar'}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            var html="<option value='0'>--------- SUCURSAL ---------</option>";
            if(json.sucursal!==null)
            for (var i = 0; i < json.result.sucursal.length; i++) {
                html+="<option value='"+json.result.sucursal[i].id_sucursal+"'>"+json.result.sucursal[i].nombre+"</option>";
            }
            $("#sucursal").html(html);
            $("#sucursal option[value="+json.result.id_sucursal+"]").attr("selected",true);
            html="<option value='0'>--------- ALMACEN ---------</option>";
            if(json.result.almacen!==null)
            for (var i = 0; i < json.result.almacen.length; i++) {
                html+="<option value='"+json.result.almacen[i].id_almacen+"'>"+json.result.almacen[i].nombre+"</option>";
            }
            $("#almacen option[value="+json.result.id_almacen+"]").attr("selected",true);
            $("#almacen").html(html);
            html="<option value='0'>---- MEDIDA ----</option>";
            if(json.result.unidad!==null)
            for (var i = 0; i < json.result.unidad.length; i++) {
                html+="<option value='"+json.result.unidad[i].Id_Unidad+"'>"+json.result.unidad[i].descripcion+"</option>";
            }
            $("#unidad").html(html);
            buscarInventario("");
        }
    });
});
function buscarInventario(e){
    if(e !== "" && e.keyCode !== 13){
        return ;
    }
    var texto=$("input[name=buscadorNombre]").val();
    var unidad=$("#unidad option:selected").val();
    var tipo=$("#tipo option:selected").val();
    var sucrusal=$("#sucursal option:selected").val();
    var almacen=$("#almacen option:selected").val();
    if(!validar("texto y entero",texto)){
        $("body").msmOK("En el cuadro de texto de la busqueda no coloque caracteres especiales.");
        return;
    }
    cargando(true);
    $.post(url, {proceso: 'InventarioStock', text: texto,unidad:unidad,tipo:tipo,sucursal:sucrusal,almacen:almacen}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            var html="";
            if(json.result!==null){
                for (var i = 0; i < json.result.length; i++) {
                    html+="<tr data-id='"+json.result[i].id_stock+"'><td><div class='grande'>"+json.result[i].nombre+"</div></td>";
                    html+="<td><div class='medio'>"+json.result[i].tipo+"</div></td>";
                    html+="<td><div class='chico'>"+json.result[i].cantidad+"</div></td>";
                    html+="<td><div class='chico'>"+json.result[i].unidad+"</div></td>";
                    html+="<td><div class='chico'>"+json.result[i].precio_compra+"</div></td>";
                    html+="<td><div class='chico'>"+json.result[i].precio_venta+"</div></td>";
                    html+="<td><div class='chico'><input type='number' step='0.5' min='0' value='"+json.result[i].cantidadMin+"' /></div></td>";
                    html+="<td><div class='medio'>"+json.result[i].sucursal+"</div></td>";
                    html+="<td><div class='medio'>"+json.result[i].almacen+"</div></td><tr>";
                }
            }
            $("#inventariotbl tbody").html(html);
            $("#inventariotbl").igualartabla();
        }
    });
    
}
function registrarStockMin(){
    var tr=tuplaSeleccionada("inventariotbl");
    if(tr===""){
        $("body").msmOK("Debe seleccionar la tupla que desea registrar.");
        return;
    }
    var id=tr.data("id");
    var cantmin=tr.find("input").val();
    if(parseFloat(cantmin)<0){
        $("body").msmOK("El stock minimo no puede ser negativo.");
        return;
    }
    cargando(true);
    $.post(url, {proceso: 'registrarStockmin', stock: id,cant:cantmin}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
        }
    });
}
function formularioProducto(tipo){
    localStorage.setItem("idstock","0");
    if(tipo!==0){
        var tr=tuplaSeleccionada("inventariotbl");
        if(tr===""){
            $("body").msmOK("Debe seleccionar una fila de la tabla para saber a que almacen o sucursal se registrará la compra.");
            return;
        }
        var id=tr.data("id");
        localStorage.setItem("idstock",id);
    }
    localStorage.setItem("atras", "StockBajo.php");
    $(location).attr('href',"RegistrarCompra.php");
}
function exportar(tabla) {
    exportarExcel(tabla,"Reporte_StockBajo_"+fechaActualReporte());
}
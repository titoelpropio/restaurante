var estadomenu = true;
$(document).ready(function () {
    var menu = $("#menu");
    var contenedromenu = $("#contenedormenu");
    var solapa = $("#solapamenu");
    var contSubMenu = $("#submenucontenedor");
    localStorage.setItem("atras", "");
    localStorage.setItem("idstock", "0");
    contSubMenu.css({
        top: menu.position().top - 16,
        left: menu.position().left - 30
    });
    solapa.css({
        top: menu.position().top - 15,
        left: menu.position().left - 30
    });
    menu.click(function () {
        if (estadomenu) {
            contenedromenu.animate({
                height: "180px"
                , width: "180px",
                borderRadius: 95,
                marginLeft: -40,
                marginTop: -40
            }, 300, function () {
                estadomenu = false;
            });
        } else {
            contenedromenu.animate({
                height: "35px"
                , width: "35px",
                marginLeft: 9,
                marginTop: 8,
                borderRadius: 25
            }, 300, function () {
                estadomenu = true;
            });
        }
    });
    contenedromenu.mouseout(function () {

    });
});
$(window).resize(function () {
    var menu = $("#menu");
    var solapa = $("#solapamenu");
    var contSubMenu = $("#submenucontenedor");
    contSubMenu.css({
        top: menu.position().top - 16,
        left: menu.position().left - 30
    });
    solapa.css({
        top: menu.position().top - 15,
        left: menu.position().left - 30
    });
});

function Menu(texto) {
    $("#btnSubmenu").visible(1);
    var items="";
    switch (texto){
        case "ATENCION AL CLIENTE":
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Atencion</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Pedidos</div>";
            break;
        case "INVENTARIO":
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Creacion de Producto</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Registro de Inventario</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Stock Bajo</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Registro Proveedor</div>";
            break;
        case "ADMINISTRACION":
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Registrar Sucursal</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Registrar Almacen</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Configurar Restaurante</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Registrar Personal</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Registro Personal</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Facturas Emitidas</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Reporte de movimiento</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Platillo Mas Solicitado</div>";
            break;
        case "PARAMETRIZACION":
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Parametrizar Local</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Parametrizar Mesas</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Unidad de Medida</div>";
            items+="<div class='itemSubmenu' onclick='abrirSubmenu(this)'>Tipo Plato</div>";
            break;
    }
    $("#cuerpoSubmenu h2").text(texto);
    $("#detallesubmenu").html(items);
    var contenedromenu = $("#contenedormenu");
    contenedromenu.animate({
        height: "35px"
        , width: "35px",
        marginLeft: 9,
        marginTop: 8,
        borderRadius: 25
    }, 300, function () {
        estadomenu = true;
        var cuerpo=$("#cuerpoSubmenu");
        cuerpo.animate({
            width: "300px"
        }, 400, function () {
            $("#btnSubmenu img").attr("src","Imagen/submenuAbierto.svg");
            $("#btnSubmenu").data("estado","abierto");
        });
    });
}
function submenu(e){
    var cuerpo=$("#cuerpoSubmenu");
    if($(e).data("estado")==="cerrado"){
        if(!estadomenu){
            var contenedromenu = $("#contenedormenu");
            contenedromenu.animate({
                height: "35px"
                , width: "35px",
                marginLeft: -6,
                marginTop: 0,
                borderRadius: 25
            }, 300, function () {
                estadomenu = true;
                cuerpo.animate({
                    width: "300px"
                }, 400, function () {
                    $("#btnSubmenu img").attr("src","Imagen/submenuAbierto.svg");
                    $(e).data("estado","abierto");
                });
            });
        }else{
           cuerpo.animate({
                width: "300px"
            }, 400, function () {
                $("#btnSubmenu img").attr("src","Imagen/submenuAbierto.svg");
                $(e).data("estado","abierto");
            }); 
        }
        
    }else{
        cuerpo.animate({
             width: "0"
        }, 400, function () {
            $("#btnSubmenu img").attr("src","Imagen/submenuCerrado.svg");
            $(e).data("estado","cerrado");
        });
    }
}
function abrirSubmenu(ele){
    var url="";
    localStorage.setItem("atras", "");
    localStorage.setItem("idstock", "0");
    switch ($(ele).html()){
        case "Creacion de Producto":
            url="Formularios/RegistrarCompra.php"; 
            break;
        case "Registro de Inventario":
            url="Formularios/RegistroInventario.php"; 
            break;
        case "Stock Bajo":
            url="Formularios/StockBajo.php"; 
            break;
        case "Registro Proveedor":
            url="Formularios/Proveedores.php"; 
            break;
        case "Parametrizar Local":
            url="Formularios/ParametrizarLocal.php"; 
            break;
    }
    $("#iframaportal").attr("src",url);
    var cuerpo=$("#cuerpoSubmenu");
    cuerpo.animate({
        width: "0"
   }, 400, function () {
       $("#btnSubmenu img").attr("src","Imagen/submenuCerrado.svg");
       $("#btnSubmenu").data("estado","cerrado");
   });
}

function cerrarSesion(){
    alert("cerro sesion");
}
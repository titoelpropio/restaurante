var url = "../Controlador/Proveedores_Controlador.php";
var padreSession = window.parent.$("#cerrarSession");
var listaProductos = [];
var provedor = 0;
$(document).ready(function () {
    $("#popProveedor").centrar();
    cargando(true);
    $.post(url, {proceso: 'listaProductos'}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            listaProductos = json.result;
            filtrarProvedor('');
        }
    });
    $("#popProveedor").click(function () {
        ocultarproductos();
    });
});
function proveedor(tipo) {
    if (tipo === "Abrir popup") {
        $("#popProveedor").visible();
        $(".background").visible();
        ocultarproductos();
        $("#contenedorProveedorProducto").html("");
        $("#popProveedor").limpiarFormulario();
        $("#btnregistrar").text("REGISTAR");
    }
    if (tipo === "Cerrar popup") {
        $("#popProveedor").ocultar();
        $(".background").ocultar();
        provedor = 0;
        ocultarproductos();
        $("#contenedorProveedorProducto").html("");
        $("#popProveedor").limpiarFormulario();
        $("#btnregistrar").text("REGISTAR");
    }
    if (tipo === "Crear Proveedor") {
        var nombre = $("input[name=nombre]").val();
        var direccion = $("input[name=direccion]").val();
        var telefono = $("input[name=telefono]").val();
        var correo = $("input[name=correo]").val();
        var contacto = $("input[name=contacto]").val();
        var telefonoContacto = $("input[name=telefonoContacto]").val();
        var error = "";
        if (nombre.length === 0) {
            error += "<p>-El nombre no puede estar vacío.</p>";
        }
        if (!validar("texto y entero", nombre)) {
            error += "<p>-El nombre no puede tener caracteres especiales.</p>";
        }
        if (!validar("texto y entero", direccion)) {
            error += "<p>-La dirección no puede tener caracteres especiales.</p>";
        }
        if (!validar("texto y entero", telefono)) {
            error += "<p>-El telefono no puede tener caracteres especiales.</p>";
        }
        if (correo.lengtd > 0 && !validar("correo", correo)) {
            error += "<p>-El correo no es valido.</p>";
        }
        if (!validar("texto y entero", contacto)) {
            error += "<p>-El contacto no puede tener caracteres especiales.</p>";
        }
        if (!validar("texto y entero", telefonoContacto)) {
            error += "<p>-El telefono del contacto no puede tener caracteres especiales.</p>";
        }

        var items = $(".itemProvedorProducto");
        $(".itemProvedorProducto").css("background", "white");
        var producto = [];
        for (var j = 0; j < items.length; j++) {
            var item = $(items[j]);
            var obs = item.find("input[name=obs]").val();
            var precio = item.find("input[name=precio]").val();
            if (parseFloat(precio) < 0) {
                item.css("background", "red");
                error += "<p>-El precio no puede ser negativo.</p>";
                break;
            }
            if (!validar("texto y entero", obs)) {
                item.css("background", "red");
                error += "<p>-La observacion de un producto posee caracteres especiales no admitidos.</p>";
                break;
            }
            producto.push({
                id: item.data("id"),
                obs: obs,
                precio: precio
            })
        }
        if (error !== "") {
            $("body").msmOK(error);
            return;
        }
        cargando(true);
        $.post(url, {proceso: 'crearProveedor', nombre: nombre, direccion: direccion, telefono: telefono
            , correo: correo, contacto: contacto, telefonoc: telefonoContacto, provedor: provedor, producto: producto}, function (response) {
            cargando(false);
            var json = $.parseJSON(response);
            if (json.error.length > 0) {
                if ("Error Session" === json.error) {
                    padreSession.click();
                }
                $("body").msmOK(json.error);
            } else {
                if(provedor==0){
                    $("body").msmOK("Se creo al proveedor " + nombre + " correctamente.");
                }else{
                    $("body").msmOK("Se modifico el proveedor " + nombre + " correctamente.");
                }
                $("#popProveedor").ocultar();
                $(".background").ocultar();
                provedor = 0;
                ocultarproductos();
                $("#contenedorProveedorProducto").html("");
                $("#popProveedor").limpiarFormulario();
                filtrarProvedor('');
            }
        });
    }
}
$(window).resize(function () {
    $("#resltadoProducto").css({
        left: $("input[name=buscadorProducto]").position().left,
        top: $("input[name=buscadorProducto]").position().top + 16
    });
});
function ocultarproductos() {
    $("#resltadoProducto").ocultar();
}
function buscarProveedor() {
    var html = "";
    var texto = $("input[name=buscadorProducto]").val().toUpperCase();
    if (listaProductos !== null)
        for (var i = 0; i < listaProductos.length; i++) {
            if (listaProductos[i].nombre.toUpperCase().indexOf(texto) >= 0) {
                var items = $(".itemProvedorProducto");
                var estado = true;
                for (var j = 0; j < items.length; j++) {
                    if ($(items[j]).data("id") == listaProductos[i].id_producto) {
                        estado = false;
                        break;
                    }
                }
                if (estado)
                    html += "<div onclick=\"seleccionarProducto('" + listaProductos[i].nombre + "'," + listaProductos[i].id_producto + ",'" + listaProductos[i].precio_compra + "')\">" + listaProductos[i].nombre + "</div>";
            }
        }
    if (html === "") {
        html = "<div>No se encontro ningun producto que coincida.</div>";
    }
    $("#resltadoProducto").html(html);
    $("#resltadoProducto").css({
        left: $("input[name=buscadorProducto]").position().left,
        top: $("input[name=buscadorProducto]").position().top + 16
    });
    $("#resltadoProducto").visible();
}
function seleccionarProducto(nombre, id, precio) {
    var html = "<div class='itemProvedorProducto' data-id='" + id + "'>";
    html += "<div class='contenedor80'>";
    html += "<span class='negrilla' onclick='eliminarProducto(this," + id + ")'>X</span>";
    html += "<span>" + nombre + "</span>";
    html += "</div>";
    html += "<div class='contenedor20'>";
    html += "<input type='number' class='medio' name='precio' value='" + precio + "'/>";
    html += "</div>";
    html += "<div class='clear'>";
    html += "<input type='text' name='obs' placeholder='Observación'/>";
    html += "</div>";
    html += "</div>";
    $("#contenedorProveedorProducto").append(html);
    ocultarproductos();
    $("input[name=buscadorProducto]").val("");
}
function exportar(tabla) {
    exportarExcel(tabla, "Reporte_StockBajo_" + fechaActualReporte());
}
function eliminarProducto(ele, producto) {
    if (provedor === 0) {
        $(ele).parent().parent().remove();
    } else {

    }
}
function filtrarProvedor(e) {
    
    if (e !== "" && e.keyCode !== 13) {
        return;
    }
    var text = $("input[name=buscadarProveedor]").val();
    if (!validar("texto y entero", text)) {
        $("body").msmOK("No se aceptan caracteres especiales.");
        return;
    }
    cargando(true);
    $.post(url, {proceso: 'filtrarProvedor', text: text}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            var html = "";
            for (var i = 0; i < json.result.length; i++) {
                html += "<tr ondblclick=abrirDetalleProvedor(" + json.result[i].id_Provedor + ")><td><div class='grande'>" + json.result[i].Nombre + "</div></td>";
                html += "<td><div class='medio'>" + json.result[i].direccion + "</div></td>";
                html += "<td><div class='normal'>" + json.result[i].telefono + "</div></td>";
                html += "<td><div class='medio'>" + json.result[i].correo + "</div></td>";
                html += "<td><div class='grande'>" + json.result[i].Contacto + "</div></td>";
                html += "<td><div class='normal'>" + json.result[i].Telefono_Contacto + "</div></td>";
                html += "<td><div class='grande'>" + json.result[i].producto + "</div></td></tr>";
            }
            $("#tblprovedor tbody").html(html);
            $("#tblprovedor").igualartabla();
        }
    });
}
function abrirDetalleProvedor(idProvedor) {
    $("#btnregistrar").text("GUARDAR");
    provedor = idProvedor;
    cargando(true);
    $.post(url, {proceso: 'detalleProvedor', id: idProvedor}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            $("#popProveedor").visible();
            $(".background").visible();
            ocultarproductos();
            $("#contenedorProveedorProducto").html("");
            $("#popProveedor").limpiarFormulario();
            $("input[name=nombre]").val(json.result.provedor.Nombre);
            $("input[name=direccion]").val(json.result.provedor.direccion);
            $("input[name=telefono]").val(json.result.provedor.telefono);
            $("input[name=correo]").val(json.result.provedor.correo);
            $("input[name=contacto]").val(json.result.provedor.Contacto);
            $("input[name=telefonoContacto]").val(json.result.provedor.Telefono_Contacto);
            var html = "";
            for (var i = 0; i < json.result.productos.length; i++) {
                html += "<div class='itemProvedorProducto' data-id='" + json.result.productos[i].producto_id + "'>";
                html += "<div class='contenedor80'>";
                html += "<span class='negrilla' onclick='eliminarProducto(this," + json.result.productos[i].producto_id + ")'>X</span>";
                html += "<span>" + json.result.productos[i].nombre + "</span>";
                html += "</div>";
                html += "<div class='contenedor20'>";
                html += "<input type='number' class='medio' name='precio' value='" + json.result.productos[i].precio + "'/>";
                html += "</div>";
                html += "<div class='clear'>";
                html += "<input type='text' name='obs' placeholder='Observación' value='" + json.result.productos[i].comentario + "'/>";
                html += "</div>";
                html += "</div>";

            }
            $("#contenedorProveedorProducto").append(html);
            ocultarproductos();
            $("input[name=buscadorProducto]").val("");
        }
    });

}
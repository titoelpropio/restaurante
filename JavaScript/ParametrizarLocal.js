var url = "../Controlador/ParametrizarLocal.php";
var listadoBoceto = [];
var accion = "";
var listaForma = [];
var indexAtras = 0;
var identificador = 0;
var imagenSeleccionada = -1;
var idambiente = 0;
$(document).ready(function () {
    $(".btnBoceto:eq(0)").click();
    $("#tamañoImagen").ocultar();
    $("#formulario .contenedor80").mouseout(function () {
        $("#borradorBoceto").ocultar();
    });
    cargando(true);
    $.post(url, {proceso: 'buscarBocetos'}, function (response) {
        cargando(false);
        var json = $.parseJSON(response);
        if (json.error.length > 0) {
            if ("Error Session" === json.error) {
                padreSession.click();
            }
            $("body").msmOK(json.error);
        } else {
            var html = "";
            if (json.result !== null) {
                for (var i = 0; i < json.result.length; i++) {
                    html += "<div class='itemLocal' onclick='cambioAmbiente(this)' data-id='" + json.result[i].id_Ambiente + "'>";
                    html += "<div class='foto'>";
                    html += "<img src='" + json.result[i].boceto + "' alt='" + json.result[i].nombre + "'>";
                    html += "</div>";
                    html += "<input type='text' class='medio' name='nombre' value='" + json.result[i].nombre + "'/>";
                    html += "</div>";
                    idambiente = json.result[i].id_Ambiente;
                    var img2 = new Imagen(0, 0, 0, 0, null, 0);
                    img2.src = json.result[i].boceto;
                    var forma = [];
                    forma.push(img2);
                    listadoBoceto.push({
                        accion: "lapiz",
                        listaForma: forma,
                        indexAtras: 1,
                        identificador: 1,
                        imagenSeleccionada: -1,
                        id: idambiente
                    });
                }
            } else {
                html += "<div class='itemLocal' onclick='cambioAmbiente(this)'>";
                html += "<div class='foto'>";
                html += "<img src='../Imagen/lugar.svg'>";
                html += "</div>";
                html += "<input type='text' name='nombre' value='Nuevo Ambiente'/>";
                html += "</div>";
                cargando(false);
                listadoBoceto.push({
                    accion: "lapiz",
                    listaForma: [],
                    indexAtras: 0,
                    identificador: 0,
                    imagenSeleccionada: -1,
                    id: 0
                });
            }
            html += "<div id='addambiente' onclick='agregarAmbiente()'>+</div>"
            $("#contenedorLocales .cuerpo").html(html);
        }
    });
});
function presionaMouse(e) {
    var grosor = $("#rslrango").text();
    var offset = $("#boceto").offset();
    var x = e.pageX - offset.left;
    var y = e.pageY - offset.top;
    var color = $("#colorBoceto").val();
    if (accion === "linea") {
        var linea = new Linea(x, y, x, y, grosor, color, identificador);
        listaForma.push(linea);
        pintar();
        identificador++;
        indexAtras = listaForma.length - 1;
    }
    if (accion === "rectangulo") {
        var rectangulo = new Rectangulo(x, y, 0, 0, grosor, color, identificador);
        listaForma.push(rectangulo);
        pintar();
        identificador++;
        indexAtras = listaForma.length - 1;
    }
    if (accion === "borrador") {
        var borrador = new Borrador(x + 2, y + 2, grosor, color, identificador);
        listaForma.push(borrador);
        pintar();
        identificador++;
        indexAtras = listaForma.length - 1;
    }
    if (accion === "lapiz") {
        var linea = new Linea(x, y, x, y, grosor, color, identificador);
        listaForma.push(linea);
        pintar();
    }
    if (accion === "mover") {
        for (var i = 0; i < listaForma.length; i++) {
            var item = listaForma[i];
            if (item.tipo === "Imagen"
                    && x >= item.x && x < item.x + item.ancho
                    && y >= item.y && y < item.y + item.alto) {
                imagenSeleccionada = i;
                item.seleccionado = true;
                $("#tamañoImagen").visible();
                $("input[name=alto]").val(item.alto);
                $("input[name=ancho]").val(item.ancho);
                pintar();
                break;
            } else {
                if (imagenSeleccionada !== -1) {
                    listaForma[imagenSeleccionada].seleccionado = false;
                    imagenSeleccionada = -1;
                    $("#tamañoImagen").ocultar();
                    pintar();
                }
            }
        }
    }

}
function SueltaMouse(e) {
    if (accion === "lapiz" && e.which === 1) {
        identificador++;
    }
}
function moverMouse(e) {
    if (accion === "borrador") {
        $("#borradorBoceto").visible();
    }
    if (e.which === 1) {
        var grosor = $("#rslrango").text();
        var offset = $("#boceto").offset();
        var x = e.pageX - offset.left;
        var y = e.pageY - offset.top;
        var color = $("#colorBoceto").val();
        if (accion === "lapiz") {
            var ultimoPunto = listaForma[listaForma.length - 1];
            ultimoPunto.x2 = x;
            ultimoPunto.y2 = y;
            var linea = new Linea(x, y, x, y, grosor, color, identificador);
            listaForma.push(linea);
            indexAtras = listaForma.length - 1;
            pintar();
        }
        if (accion === "linea") {
            var ultimoPunto = listaForma[listaForma.length - 1];
            ultimoPunto.x2 = x;
            ultimoPunto.y2 = y;
            pintar();
        }
        if (accion === "rectangulo") {
            var ultimoPunto = listaForma[listaForma.length - 1];
            ultimoPunto.ancho = x - ultimoPunto.x;
            ultimoPunto.alto = y - ultimoPunto.y;
            pintar()
        }
        if (accion === "borrador") {
            var borrador = new Borrador(x + 2, y + 2, grosor, color, identificador);
            listaForma.push(borrador);
            indexAtras = listaForma.length - 1;
            identificador++;
            pintar();
        }
        if (accion === "mover" && imagenSeleccionada !== -1) {
            listaForma[imagenSeleccionada].x = x + 2;
            listaForma[imagenSeleccionada].y = y + 2;
            pintar();
        }
    }
    if (accion === "borrador") {
        var offset = $("#boceto").offset();
        var left = e.pageX;
        var top = e.pageY;
        var grosor = $("#rslrango").text();
        $("#borradorBoceto").css({
            top: top + 2,
            left: left + 2,
            width: parseInt(grosor),
            height: parseInt(grosor)
        });
    }

}
function presionarOption(tipo, ele) {
    $(".btnBoceto").css({
        "box-shadow": "1px 2px 1px 2px #454545",
        "background-color": "white"
    });
    $(ele).css({
        "box-shadow": "0px 0px 0px 2px black",
        "background-color": "#D6D6D6"
    });
    if (imagenSeleccionada !== -1) {
        $("#tamañoImagen").ocultar();
        listaForma[imagenSeleccionada].seleccionado = false;
        imagenSeleccionada = -1;
    }
    if (tipo === "atras") {
        if (indexAtras === 0) {
            listaForma[0].estado = !listaForma[0].estado;
        } else {
            for (var i = indexAtras; i > 0; i--) {
                listaForma[indexAtras].estado = !listaForma[indexAtras].estado;
                indexAtras--;
                if (listaForma[indexAtras].id !== listaForma[indexAtras + 1].id) {
                    break;
                }
            }
        }
        $(".btnBoceto").css({
            "box-shadow": "1px 2px 1px 2px #454545",
            "background-color": "white"
        });
    }
    if (tipo === "siguiente") {
        if (listaForma.length - 1 === indexAtras) {
            listaForma[listaForma.length - 1].estado = true;
        } else {
            for (var i = indexAtras; i < listaForma.length - 1; i++) {
                listaForma[indexAtras].estado = !listaForma[indexAtras].estado;
                indexAtras++;
                if (listaForma[indexAtras].id !== listaForma[indexAtras - 1].id) {
                    break;
                }
            }
        }
    }
    if (tipo === "borrador") {
        $("#borradorBoceto, #boceto").css("cursor", "none");
        $("#borradorBoceto").visible();
    } else {
        $("#borradorBoceto, #boceto").css("cursor", "pointer");
        $("#borradorBoceto").ocultar();
    }
    pintar();
    accion = tipo;
}
function cambiarGrosor(valor) {
    $("#rslrango").text(valor);
}
function pintar() {
    var canvas = document.getElementById("boceto");
    var ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    for (var i = 0; i < listaForma.length; i++) {
        listaForma[i].dibujar(ctx);
    }
}
function subirFoto(input, tipo) {
    if (tipo === 1 || tipo === "1") {
        $("body").append("<input type='file' onchange='subirFoto(this,2)' id='fotocargar' style='display: none;'/>");
        $('#fotocargar').click();
        return;
    }
    if (input.files && input.files[0]) {
        cargando(true);
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.onload = function () {
                cargando(false);
                var img2 = new Imagen(0, 0, img.width, img.height, img, identificador);
                listaForma.push(img2);
                identificador++;
                indexAtras = listaForma.length - 1;
                pintar();
            };
            img.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function cambiarTamanoImagen(e) {
    if (e.keyCode !== 13) {
        return;
    }
    var ancho = $("input[name=ancho]").val();
    var alto = $("input[name=alto]").val();
    if (isNaN(ancho) || isNaN(alto)) {
        return;
    }
    listaForma[imagenSeleccionada].ancho = parseFloat(ancho);
    listaForma[imagenSeleccionada].alto = parseFloat(alto);
    pintar();
}
function agregarAmbiente() {
    var html = "";
    html += "<div class='itemLocal' onclick='cambioAmbiente(this)'>";
    html += "<div class='foto'>";
    html += "<img src='../Imagen/lugar.svg'>";
    html += "</div>";
    html += "<input type='text' name='nombre' value='Nuevo Ambiente'/>";
    html += "</div>";
    var img = new Image();
    img.onload = function () {
        cargando(false);
        listadoBoceto.push({
            accion: "lapiz",
            listaForma: [],
            indexAtras: 0,
            identificador: 0,
            imagenSeleccionada: -1,
            id: 0
        });
        $("#addambiente").before(html);
        $("#contenedorLocales .itemLocal:eq("+(listadoBoceto.length-1)+")").click();
    };
    img.src = "../Imagen/lugar.svg";
}
function cambioAmbiente(ele) {
    var index = $(ele).index();
    var listado = $("#contenedorLocales .itemLocal");
    for (var i = 0; i < listado.length; i++) {
        if ($(listado[i]).css("background-color") === "rgb(23, 181, 102)") {
            if (identificador === 0) {
                break;
            }
            listadoBoceto[i].accion = accion;
            listadoBoceto[i].listaForma = listaForma;
            listadoBoceto[i].indexAtras = indexAtras;
            listadoBoceto[i].identificador = identificador;
            listadoBoceto[i].imagenSeleccionada = imagenSeleccionada;
            break;
        }
    }
    if (listadoBoceto[index].listaForma.length>0 && listadoBoceto[index].listaForma[0].imagen === null) {
        var img = new Image();
        img.onload = function () {
            listadoBoceto[index].listaForma[0].imagen=img;
            listadoBoceto[index].listaForma[0].ancho=img.width;
            listadoBoceto[index].listaForma[0].alto=img.height;
            accion = listadoBoceto[index].accion;
            listaForma = listadoBoceto[index].listaForma;
            indexAtras = listadoBoceto[index].indexAtras;
            identificador = listadoBoceto[index].identificador;
            imagenSeleccionada = listadoBoceto[index].imagenSeleccionada;
            $("#contenedorLocales .itemLocal").css("background-color", "white");
            $(ele).css("background-color", "#17B566");
            pintar();
        };
        img.src = listadoBoceto[index].listaForma[0].src;
    } else {
        accion = listadoBoceto[index].accion;
        listaForma = listadoBoceto[index].listaForma;
        indexAtras = listadoBoceto[index].indexAtras;
        identificador = listadoBoceto[index].identificador;
        imagenSeleccionada = listadoBoceto[index].imagenSeleccionada;
        $("#contenedorLocales .itemLocal").css("background-color", "white");
        $(ele).css("background-color", "#17B566");
        pintar();
    }


}
function guardarBoceto() {
    var listado = $("#contenedorLocales .itemLocal");
    var guardados = [];
    $("body").append("<canvas id='canvas' style='display: none;'></canvas>");
    cargando(true);
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext('2d');
    canvas.width = 690;
    canvas.height = 444;
    for (var i = 0; i < listado.length; i++) {
        if ($(listado[i]).css("background-color") === "rgb(23, 181, 102)") {
            listadoBoceto[i].accion = accion;
            listadoBoceto[i].listaForma = listaForma;
            listadoBoceto[i].indexAtras = indexAtras;
            listadoBoceto[i].identificador = identificador;
            listadoBoceto[i].imagenSeleccionada = imagenSeleccionada;
        }
        ctx.clearRect(0, 0, 690, 444);
        if (listadoBoceto[i].id === 0 && listadoBoceto[i].identificador === 0 || listadoBoceto[i].id > 0 && listadoBoceto[i].identificador === 1) {
            continue;
        }
        for (var j = 0; j < listadoBoceto[i].listaForma.length; j++) {
            listadoBoceto[i].listaForma[j].dibujar(ctx);
        }
        var id = listadoBoceto[i].id;
        var nombre = $(listado[i]).find("input[name=nombre]").val();
        var boceto = "";
        if(listadoBoceto[i].listaForma[0].imagen===null){
            boceto = listadoBoceto[i].listaForma[0].src;
        }else{
            boceto = canvas.toDataURL("image/png");
        }
        $(listado[i]).find("img").attr("src", boceto);
        guardados.push({
            id: id,
            nombre: nombre,
            boceto: boceto
        });
    }
    $("#canvas").remove();
    //cargando(true);
    $.post(url, {proceso: 'guardarBocetos', bocetos: guardados}, function (response) {
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
function eliminarBoceto() {
    var id = 0;
    var listado = $("#contenedorLocales .itemLocal");
    var eliminar="";
    for (var i = 0; i < listado.length; i++) {
        if ($(listado[i]).css("background-color") === "rgb(23, 181, 102)") {
            id = listadoBoceto[i].id;
            eliminar=i;
            if (id === 0) {
                if (listado.length === 1) {
                    accion = "Lapiz";
                    listaForma = [];
                    indexAtras = 0;
                    identificador = 0;
                    imagenSeleccionada = -1;
                    $("#contenedorLocales .itemLocal:eq(0)").css("background-color", "#17B566");
                } else {
                    listadoBoceto.splice(i, 1);
                    $(listado[i]).remove();
                    $("#contenedorLocales .itemLocal").css("background-color", "white");
                    $("#contenedorLocales .itemLocal:eq(0)").css("background-color", "#17B566");
                    accion = listadoBoceto[0].accion;
                    listaForma = listadoBoceto[0].listaForma;
                    indexAtras = listadoBoceto[0].indexAtras;
                    identificador = listadoBoceto[0].identificador;
                    imagenSeleccionada = listadoBoceto[0].imagenSeleccionada;
                }
                pintar();
            }
            break;
        }
    }
    if (id !== 0) {
        cargando(true);
        $.post(url, {proceso: 'eliminarBoceto', id: id}, function (response) {
            cargando(false);
            var json = $.parseJSON(response);
            if (json.error.length > 0) {
                if ("Error Session" === json.error) {
                    padreSession.click();
                }
                $("body").msmOK(json.error);
            }else{
                if (listado.length === 1) {
                    listadoBoceto.splice(eliminar, 1);
                    $(listado[eliminar]).remove();
                    var html = "<div class='itemLocal' onclick='cambioAmbiente(this)'>";
                    html += "<div class='foto'>";
                    html += "<img src='../Imagen/lugar.svg'>";
                    html += "</div>";
                    html += "<input type='text' name='nombre' value='Nuevo Ambiente'/>";
                    html += "</div>";
                    cargando(false);
                    listadoBoceto.push({
                        accion: "lapiz",
                        listaForma: [],
                        indexAtras: 0,
                        identificador: 0,
                        imagenSeleccionada: -1,
                        id: 0
                    });
                    html += "<div id='addambiente' onclick='agregarAmbiente()'>+</div>"
                    $("#contenedorLocales .cuerpo").html(html);
                }else{
                    listadoBoceto.splice(eliminar, 1);
                    $(listado[eliminar]).remove();
                }
                
            }
        });
    }
}
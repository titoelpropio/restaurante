<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Parametrizacion del local</title>
        <link href="../Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <script src="../JavaScript/Plugin/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/jquery-ui.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="../JavaScript/ParametrizarLocal.js" type="text/javascript"></script>
        <script src="../JavaScript/Clases.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="formulario" class="noselect">
            <h1>Parametrizacion de Ambientes</h1>
            <div class='contenedor80'>
                <div class="negrilla" style ="height: 25px; padding: 0;">
                    <span class='negrilla'>BOCETO</span>
                    <div id="tamañoImagen" class="alineacionDerecha">
                        Alto <input type='text' class='pequeno' name='ancho' onkeyup="cambiarTamanoImagen(event)"/>
                        Ancho <input type='text' class='pequeno' name='alto' onkeyup="cambiarTamanoImagen(event)"/>
                    </div>
                </div>
                <canvas id="boceto" width="690" height="444" onmousedown="presionaMouse(event)" onmouseout="SueltaMouse(event)"  onmousemove="moverMouse(event)" onmouseup="SueltaMouse(event)">
                    
                </canvas> 
            </div>
            <div class='contenedor20' id="contenedorLocales">
                <div class='negrilla centrar'>AMBIENTES</div>
                <div class='cuerpo'></div>
            </div>
            <div class='clear'>
                <input type='color' id="colorBoceto"/>
                <input type='range' min="1" max="20" value="1" step="1" id="grosor"  onchange="cambiarGrosor(this.value)" class="grande"/>
                <span class='negrilla' id="rslrango">1</span>
                <div class='btnBoceto' onclick="presionarOption('lapiz',this)" title="Lapíz">
                    <img src="../Imagen/lapiz.svg" alt="Lapíz"/>
                </div>
                <div class='btnBoceto' onclick="presionarOption('linea',this)" title="Linea">
                    <img src="../Imagen/linea.svg" alt="Linea"/>
                </div>
                <div class='btnBoceto' onclick="presionarOption('rectangulo',this)" title="Rectangulo">
                    <img src="../Imagen/rectangulo.svg" alt="Rectangulo"/>
                </div>
                <div class='btnBoceto' onclick="presionarOption('borrador',this)" title="Borrador">
                    <img src="../Imagen/borrador.svg" alt="Borrador"/>
                </div>
                <div class='btnBoceto' onclick="presionarOption('atras',this)" title="Atras">
                    <img src="../Imagen/atras.svg" alt="Atras"/>
                </div>
                <div class='btnBoceto' onclick="presionarOption('siguiente',this)" title="Siguientes">
                    <img src="../Imagen/sig.svg" alt="Siguientes"/>
                </div>
                <div class='btnBoceto' onclick="subirFoto(this,1)" title="Subir Imagen">
                    <img src="../Imagen/subir.svg" alt="Subir Imagen"/>
                </div>
                <div class='btnBoceto' onclick="presionarOption('mover',this)" title="Mover Imagen">
                    <img src="../Imagen/mover.svg" alt="Mover Imagen"/>
                </div>
                <div class='btnBoceto medio' onclick="guardarBoceto()" title="Guardar Cambios">
                    <img src="../Imagen/guardar.svg" alt="Mover Imagen"/>
                </div>
                <div class='btnBoceto medio' onclick="eliminarBoceto()" title="Eliminar Ambiente">
                    <img src="../Imagen/delete.svg" alt="Eliminar Ambiente"/>
                </div>
            </div>
        </div>
        <div id="borradorBoceto" onmouseout="moverMouse(event)" onmouseover="moverMouse(event)"></div>
    </body>
</html>

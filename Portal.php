<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>PORTAL</title>
        <link href="Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <script src="JavaScript/Plugin/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="JavaScript/Plugin/jquery-ui.js" type="text/javascript"></script>
        <script src="JavaScript/Plugin/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="JavaScript/Portal.js" type="text/javascript"></script>
    
    </head>
    <body id="bodyprincipal">
        <button type="hidden" id="cerrarSession" onclick="cerrarSesion()">holi</button>
        <div id="solapamenu">
            <div id="contenedormenu">
                <div id="itemmenu1" onclick="Menu('ATENCION AL CLIENTE')">
                    <img src="Imagen/atencion.svg" alt=""/>
                </div>
                <div id="itemmenu2" onclick="Menu('INVENTARIO')">
                    <img src="Imagen/inventario.svg" alt=""/>
                </div>
                <div id="itemmenu3" onclick="Menu('ADMINISTRACION')">
                    <img src="Imagen/administacion.svg" alt=""/>
                </div>
                <div id="itemmenu4" onclick="Menu('PARAMETRIZACION')">
                    <img src="Imagen/parametrizacion.svg" alt=""/>
                </div>
            </div>
        </div>
        <div id="divprincipal" >
            <div id="menu">
                <img src="Imagen/menu.svg" alt=""/>
            </div>
            <iframe id="iframaportal" >
            </iframe>
        </div>
        <div id="submenucontenedor">
            <div id="cuerpoSubmenu">
                <h2></h2>
                <div id="detallesubmenu">
                    
                </div>
            </div>
            <div id="btnSubmenu" onclick="submenu(this)" data-estado="cerrado">
                <img src="Imagen/submenuCerrado.svg" alt=""/>
            </div>
        </div>
    </body>
</html>

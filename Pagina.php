<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <script src="JavaScript/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="index.js" type="text/javascript"></script>
        <script src="JavaScript/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="JavaScript/jquery-ui.js" type="text/javascript"></script>
        <script src="JavaScript/index.js" type="text/javascript"></script>
        <title></title>
    </head>
    <body id="bodyprincipal" style="font-family: Comic Sans MS" > 
        <div id="divprincipal">
            <center>
                <menu id="idmenu"  >
                    <div></div>
                    <span onclick="popup()" style="cursor: pointer">principal</span>
                    <span onclick="cambiarMenu('Formularios/Cliente.php')">Cliente</span>
                    <span onclick="cambiarMenu('Formularios/RegistroEmpresa.php')">REGISTRO</span>
                    <span onclick="cambiarMenu('Formularios/Login.php')">home</span>
                </menu></center>
            <div id="idcontenedor">
                <iframe id="frameprincipal">

                </iframe>
            </div>

            <div class="background" onclick="cerrarpopup()">

            </div>
            <div class="popup grande3">
                <div id="imagenpopup">
                    <img src="JavaScript/img376.jpg" alt=""/>
                </div>
                <div class="centrar">
                    <span class="negrillaenter">cuenta</span>
                    <input type="text" class="grande" />
                    <span class="negrillaenter">contrase;a</span>
                    <input type="text" class="grande"><br>
                    <button class="negrilla">entrar</button>
                </div>
            </div>
        </div>

    </body>
</html>

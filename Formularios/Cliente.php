<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <link href="../Estilo/EstiloFecha.css" rel="stylesheet" type="text/css"/>
        <script src="../JavaScript/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../JavaScript/jquery-ui.js" type="text/javascript"></script>
        <script src="../JavaScript/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="../JavaScript/cliente.js" type="text/javascript"></script>
    <a href="../Clases/HERRAMIENTASPHP.php"></a>
    <title></title>
</head>
<body style="font-family: comic sans ms">
    <div class="cuerpoFormulario">

        <div class="contenedor50">
            <span class="negrillaenter ">foto</span>
            <div id="fotoperfil">
                <img id="foto" src="../JavaScript/img376.jpg" alt="" onclick="cargarImagen(this, 1)" class="point"/>
            </div>
            <span class="negrillaenter ">C.I.</span>
            <input type="text" class="grande2" name="ci"/>
            <span class="negrillaenter ">nombre completo</span>
            <input type="text" class="grande2" name="nombre"/>

            <span class="negrillaenter ">direccion</span>
            <input type="text" class="grande2" name="direccion"/>
            <span class="negrillaenter ">telefono</span>
            <input type="text" class="radius" name="telefono"/>
            <span class="negrillaenter">fecha de nacimiento: </span>
            <input id="edad" type="date" name="edad" class="fecha medio radius">

        </div>
        <div class="contenedor50">
            <span class="negrillaenter" >correo electronico</span>
            <input type="text" class="grande" name="correo"/>
            <span class="negrillaenter ">cuenta</span>
            <input type="text" class="medio radius" name="cuenta"/>      
            <span class="negrillaenter">contraseña</span>
            <input type="password" class="medio  radius" name="contraseña" id="contraseña">
            <span class="negrillaenter">repita la contraseña</span>
            <input type="password" class="medio radius" name="rcontraseña" >
            <input type="file" id="fotocargar" style="display:none" onchange="cargarImagen(this, 2)">
            <canvas id="canvas" style="display: none"></canvas>

        </div>
   
        <div >
            <button class="medio negrilla point" id="bvalidar" onclick="crearCliente()">REGISTRAR</button>
        </div>
    </div>
</body>
</html>

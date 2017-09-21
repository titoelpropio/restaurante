<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="../Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <link href="../Estilo/EstiloFecha.css" rel="stylesheet" type="text/css"/>
        <script src="../JavaScript/Plugin/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/jquery-ui.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="../JavaScript/RegistroEmpresa.js" type="text/javascript"></script>
    </head>
    <body style="font-family: Comic Sans MS;">
    <?php
    include_once "../Clases/CONN.php";
    include_once "../Clases/REGIONAL.php";
    ?>
    <div class="cuerpoFormulario">
        <h1 class="centrar">REGISTRO DE EMPRESA</h1><br>
        <div class="contenedor50">
            <span class="negrilla grande2">EMPRESA</span><br>
            <div id="divlogo">

                <img id="logo" src="../JavaScript/img376.jpg" alt="" onclick="cargarImagen(this, 1)" class="point"/>
                <input type="file" id="fotocargar" style="display:none" onchange="cargarImagen(this, 2)">
                <canvas id="canvas" style="display: none"></canvas>
            </div>
            <span class="negrillaenter">Nombre</span>
            <input type="text" class="grande2" name="nombre">
            <span class="negrillaenter">Razon social</span>
            <input type="text" class="grande2" name="razonsocial"><br>

            <br>
            <span class="negrilla grande2">SUCURSAL</span><br>
            <span class="negrillaenter">Nombre</span>
            <input id="nombres" type="text" class="grande2" name="nombre">
            <span class="negrillaenter">Nit</span>
            <input type="text" class="grande2" name="nit"><br>
            <span class="negrillaenter">Direccion</span>
            <input type="text" class="grande2" name="direccions">
            <span class="negrillaenter">Regional</span>
            <select class="radius negrilla" id="regional" class="medio">
                <?php
                $con = new CONN("rest", "wdigital");
                $regional = new REGIONAL($con);
                $listaregional = $regional->todo();
                $resultado = "<option value='0'>-seleccione regional-</option>";
                if ($listaregional !== null) {
                    for ($index = 0; $index < count($listaregional); $index++) {
                        $resultado .= "<option value='"
                                . $listaregional[$index]->id_regional
                                . "'>"
                                . $listaregional[$index]->descripcion
                                . "</option>";
                    }
                }
                echo "$resultado";
                ?>
            </select>
        </div>
        <div class="contenedor50">



            <span class="negrilla grande2">PERSONAL</span>
            <span class="negrillaenter">Nombre</span>
            <input id="nombrep" type="text" class="grande2" name="nombre">
            <span class="negrillaenter">Cuenta</span>
            <input type="text" class="grande2" name="cuenta"><br>
            <span class="negrillaenter">Contraseña</span>
            <input type="password" class="grande2" name="contraseña" id="password">
            <span class="negrillaenter">Repita la contraseña</span>
            <input type="password" class="grande2" id="rpassword" >
            <span  class="negrillaenter">Rol</span>
            <select id="rol" class="radius negrilla">
                <option  value="0">-Seleccione un rol-</option>
                <option  value="1">administrador</option>
                <option  value="2">vendedor</option>
                <option  value="3">almacenero</option>
            </select>           
            <span class="negrillaenter ">Telefono</span>
            <input type="text" class="radius" name="telefono"/>
            <span class="negrillaenter ">Sueldo</span>
            <input type="text" class="radius" name="sueldo"><br>
            <span class="negrillaenter ">Direccion</span>
            <input type="text" class="grande2" name="direccionp"/>
            <span class="negrillaenter grande">Fecha Contratado</span>
            <input type="date" class="grande2 fecha medio" name="fechacontratado"><br>
            <br>

        </div>
        <div style="clear: both"></div>
        <div class="centrar">

            <button onclick="crearRestaurante()" class="medio point  negrilla" style="position: initial"> registrar</button>
        </div>

    </div>
</body>
</html>

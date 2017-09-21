<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Compra</title>
        <link href="../Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <script src="../JavaScript/Plugin/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/jquery-ui.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="../JavaScript/RegistrarCompra.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="formulario">
            <h1>Registro de Compra</h1>
            <div id="compraRegistro">
                <div class='contenedor50'>
                    <span class='negrilla'>Foto</span>
                    <div id="fotoperfil">
                        <img src="../Imagen/food.svg" alt="Comida" onclick="cargarImagen(this,1)" class="point"/>
                    </div>
                    <span class='negrillaenter'>Nombre del producto</span>
                    <input type='text' class='grande' name='nombre'/>
                    <span class='negrillaenter'>Cantidad</span>
                    <input type='number' min="0" step="0.5" class='normal' name='cantidad'/><br>
                    <span class='negrilla'>Unidad de Medida</span><span class='mas' onclick="masunida(this)">(+)</span><br>
                    <select id='unidad' class="medio">
                    </select>
                    <span class='negrillaenter'>Tipo de Producto</span>
                    <select id='tipo' class="medio" onchange="cambiotipo()">
                        <option value='Ingredientes'>Ingredientes</option>
                        <option value='Bebidas'>Bebidas</option>
                        <option value='Ventas'>Ventas</option>
                    </select>
                </div>
                <div class='contenedor50'>
                    <span class='negrillaenter'>Precio Compra</span>
                    <input type='number' min="0" step="0.5" class='normal' name='preciocompra'/>
                    <span class='negrillaenter' id="pventa" style="display: none;">Precio Venta</span>
                    <input type='number' min="0" step="0.5"  style="display: none;" class='normal' name='precioventa'/>
                    <span class='negrillaenter'>Stock min</span>
                    <input type='number' min="0" step="0.5" class='normal' name='cantmin'/>
                    <span class='negrillaenter'>Sucursal</span>
                    <select id='sucursal' class="grande">
                    </select>
                    <span class='negrillaenter'>Almacen</span>
                    <select id='almacen' class="grande">
                    </select>
                    <span class='negrillaenter'>Fecha Comprada</span>
                    <input type='text' class='normal fecha' name='fecha'/>
                </div>    
            </div>
            <div class='centrar clear'>
                <button onclick='atras()' class='medio' id="atras">VOLVER</button>
                <button onclick='registroCompra()' class='medio'>REGISTRAR</button>
            </div>
        </div>
        <div class='popup centrar' id="nuevaunidad">
            <span class='negrillaenter'>Nueva Unidad</span>
            <input type='text' class='grande' name='unidadNueva' onblur="masunida()" onkeyup="crearUnidad(event,this)" placeholder="Descripcion de la unidad de medida"/>
        </div>
    </body>
</html>

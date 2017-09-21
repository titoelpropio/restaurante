<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Inventario</title>
        <link href="../Estilo/estilos.css" rel="stylesheet" type="text/css"/>
        <script src="../JavaScript/Plugin/jquery-2.1.3.min.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/jquery-ui.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/HERRAMIENTAS.js" type="text/javascript"></script>
        <script src="../JavaScript/Plugin/tableExport.min.js" type="text/javascript"></script>
        <script src="../JavaScript/Proveedores.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="formulario">
            <h1>Listado de Proveedores</h1>
            <div class='centrar'>
                <input type='text' class='grande2 centrarTexto' onkeyup="filtrarProvedor(event)" name='buscadarProveedor' placeholder="CRITERIO DE BUSQUEDA"/>
            </div>
            <table id="tblprovedor" >
                <thead>
                    <th ><div class='grande'>Nombre</div></th>
                    <th><div class='medio'>Dirección</div></th>
                    <th><div class='normal'>Telefono</div></th>
                    <th><div class='medio'>Correo</div></th>
                    <th><div class='grande'>Contacto</div></th>
                    <th><div class='normal'>Telefono Contacto</div></th>
                    <th><div class='grande'>Productos</div></th>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <div class='minitext centrar'>Al darle doble click a algun proveedor podra verlo con mas detalle.</div>
            <div class='centrar'>
                <button onclick="proveedor('Abrir popup')" class='grande'>NUEVO PROVEEDOR</button>
                <button onclick="exportar('tblprovedor')" class='grande'>EXPORTAR A EXCEL</button>
            </div>
        </div>
        <div class='background'></div>
        <div id="popProveedor" class="popup">
            <div class="tituloPop">Nuevo Proveedor</div>
            <div class='contenedor50'>
                <span class='negrillaenter'>Nombre</span>
                <input type='text' class='grande' name='nombre'/>
                <span class='negrillaenter'>Dirección</span>
                <input type='text' class='grande' name='direccion'/>
                <span class='negrillaenter'>Telefono</span>
                <input type='text' class='medio' name='telefono'/>
                <span class='negrillaenter'>Correo</span>
                <input type='text' class='grande' name='correo'/>
                <span class='negrillaenter'>Contacto</span>
                <input type='text' class='grande' name='contacto'/>
                <span class='negrillaenter'>Telefono Contacto</span>
                <input type='text' class='medio' name='telefonoContacto'/>
            </div>
            <div class='contenedor50'>
                <span class='negrillaenter'>Productos que provee</span>
                <div class='centrar'>
                    <input type='text'  class='grande2 centrarTexto' name='buscadorProducto' onkeyup="buscarProveedor()"  placeholder="CRITERIO DE BUSQUEDA DE PRODUCTO"/>
                    <div id="resltadoProducto">
                        
                    </div>
                </div>
                <div id="contenedorProveedorProducto">
                    
                </div>
            </div>
            <div class='clear centrar'>
                <button onclick="proveedor('Crear Proveedor')" class='medio' id="btnregistrar">REGISTRAR</button>
                <button onclick="proveedor('Cerrar popup')" class='medio'>CANCELAR</button>
            </div>
        </div>
    </body>
</html>

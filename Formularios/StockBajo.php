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
        <script src="../JavaScript/StockBajo.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="formulario">
            <h1>Reporte Stock Bajo</h1>
            <div class='centrar'>
                <input type='text' onkeyup="buscarInventario(event)" class='grande centrarTexto' name='buscadorNombre' placeholder="Buscadar por Nombre"/>
                <select id='tipo' class="normal">
                    <option value='Todos'>------ TIPO ------</option>
                    <option value='Ingredientes'>Ingredientes</option>
                    <option value='Bebidas'>Bebidas</option>
                    <option value='Ventas'>Ventas</option>
                </select>
                <select id='unidad' class="normal">
                    <option value='0'>---- MEDIDA ----</option>
                </select>
                <select id='sucursal' class="medio">
                    <option value='0'>--------- SUCURSAL ---------</option>
                </select>
                <select id='almacen' class="medio">
                    <option value='0'>--------- ALMACEN ---------</option>
                </select>
                <button onclick="buscarInventario('')" class='medio btnBusqueda'>BUSCAR</button>
            </div>
            <table id="inventariotbl">
                <thead>
                    <th><div class='grande'>Nombre del Producto</div></th>
                    <th><div class='medio'>Tipo</div></th>
                    <th><div class='chico'>Stock</div></th>
                    <th><div class='chico'>Medida</div></th>
                    <th><div class='chico'>Precio Compra</div></th>
                    <th><div class='chico'>Precio Venta</div></th>
                    <th><div class='chico'>Stock Minmo</div></th>
                    <th><div class='medio'>Sucursal</div></th>
                    <th><div class='medio'>Almacen</div></th>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
            <div class='centrar clear'>
                <button onclick='formularioProducto(1)' class='grande'>REGISTRAR COMPRA</button>
                <button onclick='registrarStockMin()' class='grande'>REGISTRAR STOCK MIN.</button>
                <button onclick="exportar('inventariotbl')" class='grande'>EXPORTAR A EXCEL</button>
            </div>
        </div>
        
    </body>
</html>

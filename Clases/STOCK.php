<?php

class STOCK {

    var $id_stock;
    var $sucursal_id;
    var $almacen_id;
    var $Producto_Id;
    var $cantidad;
    var $cantidadmin;
    var $CON;

    function STOCK($con) {
        $this->CON = $con;
    }

    function contructor($id_stock, $sucursal_id, $almacen_id, $Producto_Id, $cantidad, $cantidadmin) {
        $this->id_stock = $id_stock;
        $this->sucursal_id = $sucursal_id;
        $this->almacen_id = $almacen_id;
        $this->Producto_Id = $Producto_Id;
        $this->cantidad = $cantidad;
        $this->cantidadmin = $cantidadmin;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $stock = new STOCK();
                $stock->id_stock = $row['id_stock'] == null ? "" : $row['id_stock'];
                $stock->sucursal_id = $row['sucursal_id'] == null ? "" : $row['sucursal_id'];
                $stock->almacen_id = $row['almacen_id'] == null ? "" : $row['almacen_id'];
                $stock->Producto_Id = $row['Producto_Id'] == null ? "" : $row['Producto_Id'];
                $stock->cantidad = $row['cantidad'] == null ? "" : $row['cantidad'];
                $stock->cantidadmin = $row['cantidadmin'] == null ? "" : $row['cantidadmin'];
                $lista[] = $stock;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todo() {
        $consulta = "select * from eldebatedegusto.STOCK";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.STOCK where id_stock=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function inventario($texto, $sucursal, $almacen, $unidad, $tipo, $restaurantesession) {
        $sucursalTxt = "";
        $almacenTxt = "";
        $unidadTxt = "";
        $tipoTxt = "";
        if ($sucursal !== "0") {
            $sucursalTxt = " and stock.sucursal_id=$sucursal";
        }
        if ($almacen !== "0") {
            $almacenTxt = " and stock.almacen_id=$almacen";
        }
        if ($unidad !== "0") {
            $unidadTxt = " and producto.unidad_id=$unidad";
        }
        if ($tipo !== "Todos") {
            $tipoTxt = " and producto.tipo='$tipo'";
        }
        $consulta = "SELECT stock.id_stock, producto.nombre,producto.precio_compra,producto.precio_venta";
        $consulta .= ",stock.cantidad, stock.cantidadMin,unidad.descripcion as unidad, producto.tipo";
        $consulta .=", stock.sucursal, '' as almacen";
        $consulta .=" FROM eldebatedegusto.producto, eldebatedegusto.unidad,";
        $consulta .="(select stock.id_stock,stock.cantidad, stock.cantidadMin";
        $consulta .=",stock.producto_id";
        $consulta .=",sucursal.nombre as sucursal";
        $consulta .=" from eldebatedegusto.stock, eldebatedegusto.sucursal ";
        $consulta .=" where stock.sucursal_id=sucursal.id_sucursal $sucursalTxt $almacenTxt) as stock";
        $consulta .=" where  producto.nombre like '%$texto%'  $tipoTxt  $unidadTxt and unidad.restaurante_id=$restaurantesession  and";
        $consulta .=" stock.producto_id=producto.id_producto and unidad.id_unidad=producto.unidad_id";
        $consulta .=" union   ";
        $consulta .= "SELECT stock.id_stock, producto.nombre,producto.precio_compra,producto.precio_venta";
        $consulta .= ",stock.cantidad, stock.cantidadMin,unidad.descripcion as unidad, producto.tipo";
        $consulta .=", stock.almacen, '' as sucursal";
        $consulta .=" FROM eldebatedegusto.producto, eldebatedegusto.unidad,";
        $consulta .="(select stock.id_stock,stock.cantidad, stock.cantidadMin";
        $consulta .=",stock.producto_id";
        $consulta .=",almacen.nombre as almacen";
        $consulta .=" from eldebatedegusto.stock, eldebatedegusto.almacen ";
        $consulta .=" where stock.almacen_id=almacen.id_almacen $sucursalTxt $almacenTxt) as stock";
        $consulta .=" where  producto.nombre like '%$texto%'  $tipoTxt  $unidadTxt and unidad.restaurante_id=$restaurantesession  and";
        $consulta .=" stock.producto_id=producto.id_producto and unidad.id_unidad=producto.unidad_id";
        $resultado = $this->CON->consulta($consulta);
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $stock = array();
                $stock["id_stock"]=$row["id_stock"];
                $stock["nombre"]=$row["nombre"];
                $stock["precio_compra"]=$row["precio_compra"];
                $stock["precio_venta"]=$row["precio_venta"];
                $stock["cantidad"]=$row["cantidad"];
                $stock["cantidadMin"]=$row["cantidadMin"];
                $stock["unidad"]=$row["unidad"];
                $stock["tipo"]=$row["tipo"];
                $stock["sucursal"]=$row["sucursal"];
                $stock["almacen"]=$row["almacen"];
                $lista[] = $stock;
            }
            return $lista;
        } else {
            return null;
        }
    }
    function stockBajo($texto, $sucursal, $almacen, $unidad, $tipo, $restaurantesession) {
        $sucursalTxt = "";
        $almacenTxt = "";
        $unidadTxt = "";
        $tipoTxt = "";
        if ($sucursal !== "0") {
            $sucursalTxt = " and stock.sucursal_id=$sucursal";
        }
        if ($almacen !== "0") {
            $almacenTxt = " and stock.almacen_id=$almacen";
        }
        if ($unidad !== "0") {
            $unidadTxt = " and producto.unidad_id=$unidad";
        }
        if ($tipo !== "Todos") {
            $tipoTxt = " and producto.tipo='$tipo'";
        }
        $consulta = "SELECT stock.id_stock, producto.nombre,producto.precio_compra,producto.precio_venta";
        $consulta .= ",stock.cantidad, stock.cantidadMin,unidad.descripcion as unidad, producto.tipo";
        $consulta .=", stock.sucursal, '' as almacen";
        $consulta .=" FROM eldebatedegusto.producto, eldebatedegusto.unidad,";
        $consulta .="(select stock.id_stock,stock.cantidad, stock.cantidadMin";
        $consulta .=",stock.producto_id";
        $consulta .=",sucursal.nombre as sucursal";
        $consulta .=" from eldebatedegusto.stock, eldebatedegusto.sucursal ";
        $consulta .=" where stock.sucursal_id=sucursal.id_sucursal and stock.cantidad<=stock.cantidadmin $sucursalTxt $almacenTxt) as stock ";
        $consulta .=" where  producto.nombre like '%$texto%'  $tipoTxt  $unidadTxt and unidad.restaurante_id=$restaurantesession  and";
        $consulta .=" stock.producto_id=producto.id_producto and unidad.id_unidad=producto.unidad_id";
        $consulta .=" union   ";
        $consulta .= "SELECT stock.id_stock, producto.nombre,producto.precio_compra,producto.precio_venta";
        $consulta .= ",stock.cantidad, stock.cantidadMin,unidad.descripcion as unidad, producto.tipo";
        $consulta .=", stock.almacen, '' as sucursal";
        $consulta .=" FROM eldebatedegusto.producto, eldebatedegusto.unidad,";
        $consulta .="(select stock.id_stock,stock.cantidad, stock.cantidadMin";
        $consulta .=",stock.producto_id";
        $consulta .=",almacen.nombre as almacen";
        $consulta .=" from eldebatedegusto.stock, eldebatedegusto.almacen ";
        $consulta .=" where stock.almacen_id=almacen.id_almacen and stock.cantidad<=stock.cantidadmin $sucursalTxt $almacenTxt) as stock";
        $consulta .=" where  producto.nombre like '%$texto%'  $tipoTxt  $unidadTxt and unidad.restaurante_id=$restaurantesession  and";
        $consulta .=" stock.producto_id=producto.id_producto and unidad.id_unidad=producto.unidad_id";
        $resultado = $this->CON->consulta($consulta);
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $stock = array();
                $stock["id_stock"]=$row["id_stock"];
                $stock["nombre"]=$row["nombre"];
                $stock["precio_compra"]=$row["precio_compra"];
                $stock["precio_venta"]=$row["precio_venta"];
                $stock["cantidad"]=$row["cantidad"];
                $stock["cantidadMin"]=$row["cantidadMin"];
                $stock["unidad"]=$row["unidad"];
                $stock["tipo"]=$row["tipo"];
                $stock["sucursal"]=$row["sucursal"];
                $stock["almacen"]=$row["almacen"];
                $lista[] = $stock;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function modificar($id_stock) {
        $consulta = "update eldebatedegusto.STOCK set cantidad =" . $this->cantidad . ", cantidadmin =" . $this->cantidadmin . " where id_stock=" . $id_stock;
        return $this->CON->manipular($consulta);
    }
    function modificarStockmin($id_stock,$cantmin) {
        $consulta = "update eldebatedegusto.STOCK set cantidadmin =$cantmin where id_stock=" . $id_stock;
        return $this->CON->manipular($consulta);
    }

    function eliminar($id_stock) {
        $consulta = "delete from eldebatedegusto.STOCK where id_stock=" . $id_stock;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.STOCK(id_stock, sucursal_id, almacen_id, Producto_Id, cantidad, cantidadmin) values(" . $this->id_stock . "," . $this->sucursal_id . "," . $this->almacen_id . "," . $this->Producto_Id . "," . $this->cantidad . "," . $this->cantidadmin . ")";
        return $this->CON->manipular($consulta);
    }

}

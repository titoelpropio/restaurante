<?php

class PRODUCTO {

    var $Id_Producto;
    var $Precio_Compra;
    var $Precio_Venta;
    var $nombre;
    var $Unidad_Id;
    var $tipo;
    var $foto;
    var $CON;

    function PRODUCTO($con) {
        $this->CON = $con;
    }

    function contructor($Id_Producto, $Precio_Compra, $Precio_Venta, $nombre, $Unidad_Id, $tipo,$foto) {
        $this->Id_Producto = $Id_Producto;
        $this->Precio_Compra = $Precio_Compra;
        $this->Precio_Venta = $Precio_Venta;
        $this->nombre = $nombre;
        $this->Unidad_Id = $Unidad_Id;
        $this->tipo = $tipo;
        $this->foto= $foto;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $producto = new PRODUCTO();
                $producto->Id_Producto = $row['Id_Producto'] == null ? "" : $row['Id_Producto'];
                $producto->Precio_Compra = $row['Precio_Compra'] == null ? "" : $row['Precio_Compra'];
                $producto->Precio_Venta = $row['Precio_Venta'] == null ? "" : $row['Precio_Venta'];
                $producto->nombre = $row['nombre'] == null ? "" : $row['nombre'];
                $producto->Unidad_Id = $row['Unidad_Id'] == null ? "" : $row['Unidad_Id'];
                $producto->tipo = $row['tipo'] == null ? "" : $row['tipo'];
                $producto->foto = $row['foto'] == null ? "" : $row['foto'];
                $lista[] = $producto;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todo() {
        $consulta = "select * from eldebatedegusto.PRODUCTO";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.PRODUCTO where Id_Producto=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }
    function buscarXRestaurante($restaurante) {
        $consulta = "SELECT producto.id_producto ,producto.nombre,producto.precio_compra
FROM eldebatedegusto.producto
where  producto.id_producto in (select stock.producto_id
from eldebatedegusto.stock, eldebatedegusto.sucursal 
where stock.sucursal_id=sucursal.id_sucursal and sucursal.restaurante_id=$restaurante)";
        $resultado = $this->CON->consulta($consulta);
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $producto = array();
                $producto["id_producto"] = $row['id_producto'] == null ? "" : $row['id_producto'];
                $producto["precio_compra"] = $row['precio_compra'] == null ? "" : $row['precio_compra'];
                $producto["nombre"] = $row['nombre'] == null ? "" : $row['nombre'];
                $lista[] = $producto;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function modificar($Id_Producto) {
        $consulta = "update eldebatedegusto.PRODUCTO set Id_Producto =" . $this->Id_Producto . ", Precio_Compra =" . $this->Precio_Compra . ", Precio_Venta =" . $this->Precio_Venta . ", nombre ='" . $this->nombre . "', Unidad_Id =" . $this->Unidad_Id . ", tipo ='" . $this->tipo . "', foto ='" . $this->foto . "'  where Id_Producto=" . $Id_Producto;
        return $this->CON->manipular($consulta);
    }

    function eliminar($Id_Producto) {
        $consulta = "delete from eldebatedegusto.PRODUCTO where Id_Producto=" . $Id_Producto;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.PRODUCTO(Id_Producto, Precio_Compra, Precio_Venta, nombre, Unidad_Id, tipo,foto) values(" . $this->Id_Producto . "," . $this->Precio_Compra . "," . $this->Precio_Venta . ",'" . $this->nombre . "'," . $this->Unidad_Id . ",'" . $this->tipo . "','" . $this->foto . "')";
        if (!$this->CON->manipular($consulta))
            return 0;
        $consulta = "SELECT LAST_INSERT_ID() as id";
        $resultado = $this->CON->consulta($consulta);
        return $resultado->fetch_assoc()['id'];
    }

}

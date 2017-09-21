<?php

class ALMACEN {

    var $id_almacen;
    var $nombre;
    var $direccion;
    var $telefono;
    var $cantidadMin;
    var $restaurante_id;
    var $CON;

    function ALMACEN($con) {
        $this->CON = $con;
    }

    function contructor($id_almacen, $nombre, $direccion, $telefono, $cantidadMin, $restaurante_id) {
        $this->id_almacen = $id_almacen;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->cantidadMin = $cantidadMin;
        $this->restaurante_id = $restaurante_id;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $almacen = new ALMACEN();
                $almacen->id_almacen = $row['id_almacen'] == null ? "" : $row['id_almacen'];
                $almacen->nombre = $row['nombre'] == null ? "" : $row['nombre'];
                $almacen->direccion = $row['direccion'] == null ? "" : $row['direccion'];
                $almacen->telefono = $row['telefono'] == null ? "" : $row['telefono'];
                $almacen->cantidadMin = $row['cantidadMin'] == null ? "" : $row['cantidadMin'];
                $almacen->restaurante_id = $row['restaurante_id'] == null ? "" : $row['restaurante_id'];
                $lista[] = $almacen;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todo() {
        $consulta = "select * from eldebatedegusto.ALMACEN";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function buscarParaSelect($res) {
        $consulta = "select id_almacen, nombre from eldebatedegusto.almacen where almacen.restaurante_id=$res";
        $resultado = $this->CON->consulta($consulta);
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $sucursal = array();
                $sucursal["id_sucursal"] = $row['id_almacen'] == null ? "" : $row['id_almacen'];
                $sucursal["nombre"] = $row['nombre'] == null ? "" : $row['nombre'];
                $lista[] = $sucursal;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.ALMACEN where id_almacen=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function modificar($id_almacen) {
        $consulta = "update eldebatedegusto.ALMACEN set id_almacen =" . $this->id_almacen . ", nombre ='" . $this->nombre . "', direccion ='" . $this->direccion . "', telefono ='" . $this->telefono . "', cantidadMin =" . $this->cantidadMin . ", restaurante_id =" . $this->restaurante_id . " where id_almacen=" . $id_almacen;
        return $this->CON->manipular($consulta);
    }

    function eliminar($id_almacen) {
        $consulta = "delete from eldebatedegusto.ALMACEN where id_almacen=" . $id_almacen;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.ALMACEN(id_almacen, nombre, direccion, telefono, cantidadMin, restaurante_id) values(" . $this->id_almacen . ",'" . $this->nombre . "','" . $this->direccion . "','" . $this->telefono . "'," . $this->cantidadMin . "," . $this->restaurante_id . ")";
        return $this->CON->manipular($consulta);
    }

}

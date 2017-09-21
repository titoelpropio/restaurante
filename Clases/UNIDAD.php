<?php

class UNIDAD {

    var $Id_Unidad;
    var $descripcion;
    var $restaurante_id;
    var $CON;

    function UNIDAD($con) {
        $this->CON = $con;
    }

    function contructor($Id_Unidad, $descripcion, $restaurante_id) {
        $this->Id_Unidad = $Id_Unidad;
        $this->descripcion = $descripcion;
        $this->restaurante_id = $restaurante_id;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $unidad = new UNIDAD();
                $unidad->Id_Unidad = $row['Id_Unidad'] == null ? "" : $row['Id_Unidad'];
                $unidad->descripcion = $row['descripcion'] == null ? "" : $row['descripcion'];
                $unidad->restaurante_id = $row['restaurante_id'] == null ? "" : $row['restaurante_id'];
                $lista[] = $unidad;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todo($rest) {
        $consulta = "select * from eldebatedegusto.UNIDAD where restaurante_id=$rest";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.UNIDAD where Id_Unidad=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function modificar($Id_Unidad) {
        $consulta = "update eldebatedegusto.UNIDAD set Id_Unidad =" . $this->Id_Unidad . ", descripcion ='" . $this->descripcion . "' where Id_Unidad=" . $Id_Unidad;
        return $this->CON->manipular($consulta);
    }

    function eliminar($Id_Unidad) {
        $consulta = "delete from eldebatedegusto.UNIDAD where Id_Unidad=" . $Id_Unidad;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.UNIDAD(Id_Unidad, descripcion,restaurante_id) values(" . $this->Id_Unidad . ",'" . $this->descripcion . "',$this->restaurante_id)";
        return $this->CON->manipular($consulta);
    }

}

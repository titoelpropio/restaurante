<?php

class AMBIENTE {

    var $id_Ambiente;
    var $nombre;
    var $boceto;
    var $sucursal_id;
    var $CON;

    function AMBIENTE($con) {
        $this->CON = $con;
    }

    function contructor($id_Ambiente, $nombre, $boceto, $sucursal_id) {
        $this->id_Ambiente = $id_Ambiente;
        $this->nombre = $nombre;
        $this->boceto = $boceto;
        $this->sucursal_id = $sucursal_id;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $ambiente = new AMBIENTE();
                $ambiente->id_Ambiente = $row['id_Ambiente'] == null ? "" : $row['id_Ambiente'];
                $ambiente->nombre = $row['nombre'] == null ? "" : $row['nombre'];
                $ambiente->boceto = $row['boceto'] == null ? "" : $row['boceto'];
                $ambiente->sucursal_id = $row['sucursal_id'] == null ? "" : $row['sucursal_id'];
                $lista[] = $ambiente;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todo() {
        $consulta = "select * from eldebatedegusto.AMBIENTE";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.AMBIENTE where id_Ambiente=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function buscarXSucursal($idsucursal) {
        $consulta = "select * from eldebatedegusto.AMBIENTE where sucursal_id=$idsucursal";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa;
    }

    function modificar($id_Ambiente) {
        $consulta = "update eldebatedegusto.AMBIENTE set id_Ambiente =" . $this->id_Ambiente . ", nombre ='" . $this->nombre . "', boceto ='" . $this->boceto . "', sucursal_id =" . $this->sucursal_id . " where id_Ambiente=" . $id_Ambiente;
        return $this->CON->manipular($consulta);
    }

    function eliminar($id_Ambiente) {
        $consulta = "delete from eldebatedegusto.AMBIENTE where id_Ambiente=" . $id_Ambiente;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.AMBIENTE(id_Ambiente, nombre, boceto, sucursal_id) values(" . $this->id_Ambiente . ",'" . $this->nombre . "','" . $this->boceto . "'," . $this->sucursal_id . ")";
        if (!$this->CON->manipular($consulta))
            return 0;
        $consulta = "SELECT LAST_INSERT_ID() as id";
        $resultado = $this->CON->consulta($consulta);
        return $resultado->fetch_assoc()['id'];
    }

}

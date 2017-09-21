<?php

class PERSONAL {

    var $id_personal;
    var $nombre;
    var $cuenta;
    var $contrasena;
    var $rol;
    var $sueldo;
    var $estado;
    var $fechaContratado;
    var $sucursal_id;
    var $almacen_id;
    var $telefono;
    var $direccion;
    var $CON;

    function PERSONAL($con) {
        $this->CON = $con;
    }

    function contructor($id_personal, $nombre, $cuenta, $contrasena, $rol, $sueldo, $estado, $fechaContratado, $sucursal_id, $almacen_id, $telefono, $direccion) {
        $this->id_personal = $id_personal;
        $this->nombre = $nombre;
        $this->cuenta = $cuenta;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
        $this->sueldo = $sueldo;
        $this->estado = $estado;
        $this->fechaContratado = $fechaContratado;
        $this->sucursal_id = $sucursal_id;
        $this->almacen_id = $almacen_id;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $personal = new PERSONAL();
                $personal->id_personal = $row['id_personal'] == null ? "" : $row['id_personal'];
                $personal->nombre = $row['nombre'] == null ? "" : $row['nombre'];
                $personal->cuenta = $row['cuenta'] == null ? "" : $row['cuenta'];
                $personal->contrasena = $row['contrasena'] == null ? "" : $row['contrasena'];
                $personal->rol = $row['rol'] == null ? "" : $row['rol'];
                $personal->sueldo = $row['sueldo'] == null ? "" : $row['sueldo'];
                $personal->estado = $row['estado'] == null ? "" : $row['estado'];
                $personal->fechaContratado = $row['fechaContratado'] == null ? "" : $row['fechaContratado'];
                $personal->sucursal_id = $row['sucursal_id'] == null ? "" : $row['sucursal_id'];
                $personal->almacen_id = $row['almacen_id'] == null ? "" : $row['almacen_id'];
                $personal->telefono = $row['telefono'] == null ? "" : $row['telefono'];
                $personal->direccion = $row['direccion'] == null ? "" : $row['direccion'];
                $lista[] = $personal;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todo() {
        $consulta = "select * from eldebatedegusto.PERSONAL";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function logeor($cuenta, $contrasena) {

        $consulta = "select count(*) as contar from eldebatedegusto.PERSONAL where '$cuenta'=PERSONAL.cuenta and '$contrasena'=PERSONAL.contrasena";
     
        $result = $this->CON->consulta($consulta);
        return $result->fetch_assoc()['contar'];
    }

    function estadoUsuario($cuenta, $contrasena) {
        $consulta = "select personal.id_personal,personal.sucursal_id,personal.almacen_id,sucursal.restaurante_id as res  
from eldebatedegusto.PERSONAL,eldebatedegusto.sucursal 
where '$cuenta'=PERSONAL.cuenta and '$contrasena'=PERSONAL.contrasena and estado='ACTIVO'
 and personal.sucursal_id=sucursal.id_sucursal
 union
select personal.id_personal,personal.sucursal_id,personal.almacen_id, almacen.restaurante_id as res
from eldebatedegusto.PERSONAL,eldebatedegusto.almacen
where 'w'=PERSONAL.cuenta and 'w'=PERSONAL.contrasena and estado='ACTIVO'
 and personal.almacen_id=almacen.id_almacen";
        $result = $this->CON->consulta($consulta);
        if ($result->num_rows > 0) {
            $empresa = array();
            $row = $result->fetch_assoc();
            $empresa["sucursal"] = $row['sucursal_id'];
            $empresa["personal"] = $row['id_personal'];
            $empresa["almacen"] = $row['almacen_id'];
            $empresa["restaurante"] = $row['res'];
            return $empresa;
        } else {
            return null;
        }
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.PERSONAL(id_personal, nombre, cuenta, contrasena, rol, sueldo, estado, fechaContratado, sucursal_id, almacen_id, telefono, direccion) values(" . $this->id_personal . ",'" . $this->nombre . "','" . $this->cuenta . "',md5('" . $this->contrasena . "'),'" . $this->rol . "'," . $this->sueldo . ",'ACTIVO','" . $this->fechaContratado . "'," . $this->sucursal_id . "," . $this->almacen_id . ",'" . $this->telefono . "','" . $this->direccion . "')";
        $resultado = $this->CON->manipular($consulta);
        if(!$resultado)return 0;
        $consulta = "SELECT LAST_INSERT_ID() as id";
        $resultado = $this->CON->consulta($consulta);
        return $resultado->fetch_assoc()['id'];
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.PERSONAL where id_personal=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function modificar($id_personal) {
        $consulta = "update eldebatedegusto.PERSONAL set id_personal =" . $this->id_personal . ", nombre ='" . $this->nombre . "', cuenta ='" . $this->cuenta . "', contrasena ='" . $this->contrasena . "', rol ='" . $this->rol . "', sueldo =" . $this->sueldo . ", estado ='" . $this->estado . "', fechaContratado ='" . $this->fechaContratado . "', sucursal_id =" . $this->sucursal_id . ", almacen_id =" . $this->almacen_id . ", telefono ='" . $this->telefono . "', direccion ='" . $this->direccion . "' where id_personal=" . $id_personal;
        return $this->CON->manipular($consulta);
    }

    function eliminar($id_personal) {
        $consulta = "delete from eldebatedegusto.PERSONAL where id_personal=" . $id_personal;
        return $this->CON->manipular($consulta);
    }
}

<?php

class SUCURSAL {

    var $id_sucursal;
    var $Nombre;
    var $nit;
    var $direccion;
    var $nro_Factura;
    var $fecha_factura;
    var $llave_docificacion;
    var $regional_id;
    var $restaurante_id;
    var $CON;

    function SUCURSAL($con) {
        $this->CON = $con;
    }

    function contructor($id_sucursal, $Nombre, $nit, $direccion, $nro_Factura, $fecha_factura, $llave_docificacion, $regional_id, $restaurante_id) {
        $this->id_sucursal = $id_sucursal;
        $this->Nombre = $Nombre;
        $this->nit = $nit;
        $this->direccion = $direccion;
        $this->nro_Factura = $nro_Factura;
        $this->fecha_factura = $fecha_factura;
        $this->llave_docificacion = $llave_docificacion;
        $this->regional_id = $regional_id;
        $this->restaurante_id = $restaurante_id;
    }

    function rellenar($resultado) {
        
    }

    function todo() {
        $consulta = "select * from eldebatedegusto.SUCURSAL";
        $result = $this->CON->consulta($consulta);
        return $this->rellenar($result);
    }

    function buscarParaSelect($res) {
        $consulta = "select id_sucursal, nombre from eldebatedegusto.SUCURSAL where sucursal.restaurante_id=$res";
        $resultado = $this->CON->consulta($consulta);
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $sucursal = array();
                $sucursal["id_sucursal"] = $row['id_sucursal'] == null ? "" : $row['id_sucursal'];
                $sucursal["nombre"] = $row['nombre'] == null ? "" : $row['nombre'];
                $lista[] = $sucursal;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.SUCURSAL where id_sucursal=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function modificar($id_sucursal) {
        $consulta = "update eldebatedegusto.SUCURSAL set id_sucursal =" . $this->id_sucursal . ", Nombre ='" . $this->Nombre . "', nit ='" . $this->nit . "', direccion ='" . $this->direccion . "', nro_Factura =" . $this->nro_Factura . ", fecha_factura ='" . $this->fecha_factura . "', llave_docificacion ='" . $this->llave_docificacion . "', regional_id =" . $this->regional_id . ", restaurante_id =" . $this->restaurante_id . " where id_sucursal=" . $id_sucursal;
        return $this->CON->manipular($consulta);
    }

    function eliminar($id_sucursal) {
        $consulta = "delete from eldebatedegusto.SUCURSAL where id_sucursal=" . $id_sucursal;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.SUCURSAL(id_sucursal, Nombre, nit, direccion, nro_Factura, fecha_factura, llave_docificacion, regional_id, restaurante_id) values(" . $this->id_sucursal . ",'" . $this->Nombre . "','" . $this->nit . "','" . $this->direccion . "'," . $this->nro_Factura . ",'" . $this->fecha_factura . "','" . $this->llave_docificacion . "'," . $this->regional_id . "," . $this->restaurante_id . ")";
        return $this->CON->manipular($consulta);
    }

}

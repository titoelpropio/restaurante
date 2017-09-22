<?php

class PROVEDOR {

    var $id_proveedor;
    var $Nombre;
    var $direccion;
    var $telefono;
    var $correo;
    var $Contacto;
    var $Telefono_Contacto;
    var $sucursal_id;
    var $CON;

    function PROVEDOR($con) {
        $this->CON = $con;
    }

    function contructor($id_proveedor, $Nombre, $direccion, $telefono, $correo, $Contacto, $Telefono_Contacto, $sucursal_id) {
        $this->id_proveedor = $id_proveedor;
        $this->Nombre = $Nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->Contacto = $Contacto;
        $this->Telefono_Contacto = $Telefono_Contacto;
        $this->sucursal_id = $sucursal_id;
    }

    function rellenar($resultado) {
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $provedor = new PROVEDOR();
                $provedor->id_proveedor = $row['id_proveedor'] == null ? "" : $row['id_proveedor'];
                $provedor->Nombre = $row['nombre'] == null ? "" : $row['nombre'];
                $provedor->direccion = $row['direccion'] == null ? "" : $row['direccion'];
                $provedor->telefono = $row['telefono'] == null ? "" : $row['telefono'];
                $provedor->correo = $row['correo'] == null ? "" : $row['correo'];
                $provedor->Contacto = $row['Contacto'] == null ? "" : $row['Contacto'];
                $provedor->Telefono_Contacto = $row['Telefono_Contacto'] == null ? "" : $row['Telefono_Contacto'];
                $provedor->sucursal_id = $row['sucursal_id'] == null ? "" : $row['sucursal_id'];
                $lista[] = $provedor;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function todoXsucursal($texto,$sucursal) {
        $consulta = "SELECT proveedor.id_proveedor,proveedor.nombre,proveedor.direccion,proveedor.telefono";
	$consulta .= ",proveedor.correo,proveedor.Telefono_Contacto,proveedor.contacto";
        $consulta .= " FROM eldebatedegusto.proveedor";
        $consulta .= " where proveedor.sucursal_id=$sucursal and (proveedor.nombre like '%$texto%' or Telefono_Contacto like '%$texto%')";
        $resultado = $this->CON->consulta($consulta);
        if ($resultado->num_rows > 0) {
            $lista = array();
            while ($row = $resultado->fetch_assoc()) {
                $provedor =array();
                $idprovedor=$row['id_proveedor'] == null ? "" : $row['id_proveedor'];
                $provedor['id_proveedor']= $idprovedor;
                $provedor['Nombre']= $row['nombre'] == null ? "" : $row['nombre'];
                $provedor['direccion']= $row['direccion'] == null ? "" : $row['direccion'];
                $provedor['telefono']= $row['telefono'] == null ? "" : $row['telefono'];
                $provedor['correo']= $row['correo'] == null ? "" : $row['correo'];
                $provedor['Contacto']= $row['contacto'] == null ? "" : $row['contacto'];
                $provedor['Telefono_Contacto']= $row['Telefono_Contacto'] == null ? "" : $row['Telefono_Contacto'];
                $consulta=" select producto.nombre"; 
                $consulta.=" from eldebatedegusto.producto,eldebatedegusto.producto_proveedor";
                $consulta.=" where producto.id_producto=producto_proveedor.producto_id and producto_proveedor.provedor_id=$idprovedor";
                $resultado2 = $this->CON->consulta($consulta);
                $producto="";
                if ($resultado2->num_rows > 0) {
                    while ($row2 = $resultado2->fetch_assoc()) {
                        $producto.=$row2['nombre'].",";
                    }
                }
                $producto=$producto==""?"":substr($producto,0,  strlen($producto)-1);
                $provedor['producto']=$producto;
                $lista[] = $provedor;
            }
            return $lista;
        } else {
            return null;
        }
    }

    function buscarXID($id) {
        $consulta = "select * from eldebatedegusto.PROVEDOR where id_proveedor=$id";
        $result = $this->CON->consulta($consulta);
        $empresa = $this->rellenar($result);
        if ($empresa == null) {
            return null;
        }
        return $empresa[0];
    }

    function modificar($id_proveedor) {
        $consulta = "update eldebatedegusto.proveedor set id_proveedor =" . $this->id_proveedor . ", nombre ='" . $this->Nombre . "', direccion ='" . $this->direccion . "', telefono ='" . $this->telefono . "', correo ='" . $this->correo . "', contacto ='" . $this->Contacto . "', telefono_Contacto ='" . $this->Telefono_Contacto . "', sucursal_id =" . $this->sucursal_id . " where id_proveedor=" . $id_proveedor;
        echo $consulta;
        return $this->CON->manipular($consulta);
    }

    function eliminar($id_proveedor) {
        $consulta = "delete from eldebatedegusto.PROVEDOR where id_proveedor=" . $id_proveedor;
        return $this->CON->manipular($consulta);
    }

    function insertar() {
        $consulta = "insert into eldebatedegusto.proveedor(id_proveedor, Nombre, direccion, telefono, correo, Contacto, Telefono_Contacto, sucursal_id) values(" . $this->id_proveedor . ",'" . $this->Nombre . "','" . $this->direccion . "','" . $this->telefono . "','" . $this->correo . "','" . $this->Contacto . "','" . $this->Telefono_Contacto . "'," . $this->sucursal_id . ")";
        if (!$this->CON->manipular($consulta))
            return 0;
        $consulta = "SELECT LAST_INSERT_ID() as id";
        $resultado = $this->CON->consulta($consulta);
        return $resultado->fetch_assoc()['id'];
    }

}

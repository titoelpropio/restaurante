<?php

include_once "../Clases/CONN.php";
include_once "../Clases/HERRAMIENTASPHP.php";
include_once "../Clases/PRODUCTO.php";
include_once "../Clases/PROVEDOR.php";
include_once "../Clases/PRODUCTO_PROVEEDOR.php";
error_reporting(0);
$error = "";
$resultado = "";
session_start();
$almacensession = $_SESSION["almacen"];
$personalsession = $_SESSION["personal"];
$sucursalsession = $_SESSION["sucursal"];
$restaurantesession = $_SESSION["restaurante"];
$Herramienta = new Herramientas();
$con = new CONN("rest", "wdigital");
if (!$con->estado) {
    $error = "No se pudo establecer conexion. Intente nuevamente.";
    $reponse = array("error" => $error, "result" => $resultado);
    echo $_GET['callback'] . json_encode($reponse);
    return;
}
if ($personalsession == null) {
    $error = "Error Session";
    $reponse = array("error" => $error, "result" => $resultado);
    echo $_GET['callback'] . json_encode($reponse);
    return;
}
$proceso = $_POST["proceso"];
if ($proceso === "listaProductos") {
    $producto = new PRODUCTO($con);
    $resultado = $producto->buscarXRestaurante($restaurantesession);
}
if ($proceso === "crearProveedor") {
    $nombre = $_POST["nombre"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $contacto = $_POST["contacto"];
    $telefonoc = $_POST["telefonoc"];
    $provedorID = $_POST["provedor"];
    $productos = $_POST["producto"];
    if (strlen($nombre) === 0) {
        $error .= "<p>-El nombre no puede estar vacío.</p>";
    }
    if (!$Herramienta->validar("texto y entero", $nombre)) {
        $error .= "<p>-El nombre no puede tener caracteres especiales.</p>";
    }
    if (!$Herramienta->validar("texto y entero", $direccion)) {
        $error .= "<p>-La dirección no puede tener caracteres especiales.</p>";
    }
    if (!$Herramienta->validar("texto y entero", $telefono)) {
        $error .= "<p>-El telefono no puede tener caracteres especiales.</p>";
    }
    if ($correo != "" && !$Herramienta->validar("correo", $correo)) {
        $error .= "<p>-El correo no es valido.</p>";
    }
    if (!$Herramienta->validar("texto y entero", $contacto)) {
        $error .= "<p>-El contacto no puede tener caracteres especiales.</p>";
    }
    if (!$Herramienta->validar("texto y entero", $telefonoc)) {
        $error .= "<p>-El telefono del contacto no puede tener caracteres especiales.</p>";
    }
    $con->transacion();
    if ($error === "") {
        $provedor = new PROVEDOR($con);
        $provedor->contructor($provedorID, $nombre, $direccion, $telefono, $correo, $contacto, $telefonoc, $sucursalsession);
        if ($provedorID == 0) {
            $provedorID = $provedor->insertar();
            if ($provedorID == 0) {
                $error = "No se pudo insertar al proveedor $nombre. Intente nuevamente.";
            }
        } else {
            if (!$provedor->modificar($provedorID)) {
                $error = "No se pudo registar el cambio del proveedor $nombre. Intente nuevamente.";
            }else{
                $productoprovedor = new PRODUCTO_PROVEEDOR($con);
                $productoprovedor->eliminar($provedorID);
            }
        }
        if ($error == "") {
            
            for ($i = 0; $i < count($productos); $i++) {
                if (floatval($productos[i]->precio) < 0) {
                    $error.="<p>-El precio no puede ser negativo.</p>";
                    break;
                }
                if (!$Herramienta->validar("texto y entero", $productos[i]->obs)) {
                    $error.="<p>-La observacion de un producto posee caracteres especiales no admitidos.</p>";
                    break;
                }
                $productoprovedor = new PRODUCTO_PROVEEDOR($con);
                $productoprovedor->contructor($productos["$i"]["id"], $provedorID, $productos["$i"]["precio"], $productos["$i"]["obs"]);
                if(!$productoprovedor->insertar()){
                    $error = "No se pudo registar el cambio del proveedor $nombre. Intente nuevamente.";
                    break;
                }
            }
        }
        if ($error == "") {
            $con->commit();
        } else {
            $con->rollback();
        }
    }
}
if ($proceso === "filtrarProvedor") {
    $text = $_POST["text"];
    $provedor= new PROVEDOR($con);
    $resultado=$provedor->todoXsucursal($text,$sucursalsession);
}
if ($proceso === "detalleProvedor") {
    $id = $_POST["id"];
    $provedor= new PROVEDOR($con);
    $productos= new PRODUCTO_PROVEEDOR($con);
    $resultado=array();
    $resultado["provedor"]=$provedor->buscarXID($id);
    $resultado["productos"]=$productos->buscarProductos($id);
}
$reponse = array("error" => $error, "result" => $resultado);
echo $_GET['callback'] . json_encode($reponse);


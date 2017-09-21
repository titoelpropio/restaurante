<?php

include_once "../Clases/CONN.php";
include_once "../Clases/AMBIENTE.php";

error_reporting(0);
$error = "";
$resultado = "";
session_start();
$almacensession = $_SESSION["almacen"];
$personalsession = $_SESSION["personal"];
$sucursalsession = $_SESSION["sucursal"];
$restaurantesession = $_SESSION["restaurante"];
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
if ($proceso == "buscarBocetos") {
    $ambiente=new AMBIENTE($con);
    $resultado=$ambiente->buscarXSucursal($sucursalsession);
}
if ($proceso == "guardarBocetos") {
    $bocetos=$_POST["bocetos"];
    $resultado=array();
    $con->transacion();
    for ($i = 0; $i < count($bocetos); $i++) {
        $item=$bocetos[$i];
        $ambiente=new AMBIENTE($con);
        $ambiente->contructor($item["id"], $item["nombre"], $item["boceto"], $sucursalsession);
        if($item["id"]==0){
            $id=$ambiente->insertar();
            if($id==0){
                $error="No se pudo guardar los cambios. Intente nuevamente.";
                $con->rollback();
                break;
            }
            $resultado[]=$id;
        }else{
            if(!$ambiente->modificar($item["id"])){
                $error="No se pudo guardar los cambios. Intente nuevamente.";
                $con->rollback();
                break;
            }
            $resultado[]=$item->id;
        }
    }
    if($error===""){
        $con->commit();
    }
}
if ($proceso == "eliminarBoceto") {
    $ambiente=new AMBIENTE($con);
    $id=$_POST["id"];
    if(!$ambiente->eliminar($id)){
        $error="No se puede eliminar. Debe Tener mesas asignadas";
    }
}
$con->closed();
$reponse = array("error" => $error, "result" => $resultado);
echo $_POST['callback'] . json_encode($reponse);









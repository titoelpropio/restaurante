<?php
include_once "../Clases/CONN.php";
include_once "../Clases/HERRAMIENTASPHP.php";
include_once "../Clases/UNIDAD.php";
include_once "../Clases/SUCURSAL.php";
include_once "../Clases/ALMACEN.php";
include_once "../Clases/UNIDAD.php";
include_once "../Clases/PRODUCTO.php";
include_once "../Clases/STOCK.php";
include_once "../Clases/KARDEX.php";
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
if ($proceso === "iniciar") {
    $sucursal=new SUCURSAL($con);
    $almacen=new ALMACEN($con);
    $unidad=new UNIDAD($con);
    $resultado=array();
    $resultado["sucursal"]=$sucursal->buscarParaSelect($restaurantesession);
    $resultado["almacen"]=$almacen->buscarParaSelect($restaurantesession);
    $resultado["unidad"]=$unidad->todo($restaurantesession);
    $resultado["id_sucursal"]=$sucursalsession;
    $resultado["id_almacen"]=$almacensession;
}
if($proceso==="InventarioStock"){
    $texto=$_POST["text"];
    $sucursal=$_POST["sucursal"];
    $almacen=$_POST["almacen"];
    $unidad=$_POST["unidad"];
    $tipo=$_POST["tipo"];
    if(!$Herramienta->validar("texto y entero",$texto)){
        $error.="<p>En el cuadro de texto de la busqueda no coloque caracteres especiales.</p>";
    }else{
        $stock=new STOCK($con);
        $resultado=$stock->stockBajo($texto,$sucursal,$almacen,$unidad,$tipo,$restaurantesession);
    }
}
if($proceso==="registrarStockmin"){
    $id=$_POST["stock"];
    $can=$_POST["cant"];
    $stock=new STOCK($con);
    if(!$stock->modificarStockmin($id,$can)){
        $error="No se pudo registrar el cambio. Intente nuevamente.";
    }
}
$reponse = array("error" => $error, "result" => $resultado);
echo $_GET['callback'] . json_encode($reponse);


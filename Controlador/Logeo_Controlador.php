<?php
include_once "../Clases/CONN.php";
include_once "../Clases/PERSONAL.php";
include_once "../Clases/HERRAMIENTASPHP.php";


$con = new CONN("tito", "tito_root");
error_reporting(0);
$personal = new PERSONAL($con);
$error = "";
$resultado = "";
$proceso = $_POST["proceso"];
if ($proceso == "verificarLogeo") {

    $cuenta = $_POST['cuenta'];
    $contrasena = $_POST['contrasena'];
    $text = "";
    $Herramienta = new Herramientas();
    if(!$Herramienta->validar('texto y entero', $contrasena))
    {
        $text .= "<p>Por favor intruduzca su contrasena correctamente</p>";
    }
    if(!$Herramienta->validar('texto y entero', $cuenta))
    {
        $text .= "<p>Por favor intruduzca su cuenta correctamente</p>";
    }
    if(!$Herramienta->validar('vacio', $cuenta))
    {
        $text .= "<p>El campo Cuenta no puede estar vacio</p>";
    }
    if(!$Herramienta->validar('vacio', $contrasena))
    {
        $text .= "<p>El campo Contrasena no puede estar vacio</p>";
    }
    if($personal->logeor($cuenta, $contrasena)>0){
        $re=$personal->estadoUsuario($cuenta, $contrasena);
        if($re!=null){
            session_start();
            $_SESSION["sucursal"]=$re["sucursal"]==null?0:$re["sucursal"];
            $_SESSION["personal"]=$re["personal"];
            $_SESSION["almacen"]=$re["almacen"]==null?0:$re["almacen"];
            $_SESSION["restaurante"]=$re["restaurante"];
            $resultado="Entro";
        }else{
            $error="Cuenta Bloqueado";
        }
    }else{
        $error="Usuario o Contraseña es incorrecto. Intente nuevamente.";
    }
    if (strlen($text) > 0) {
        $error = $text;
    } 
}
$con->closed();
$reponse = array("error" => $error, "result" => $resultado);
echo $_POST['callback'] . json_encode($reponse);



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
$con = new CONN("tito", "tito_root");
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
    $idstock=$_POST["stock"];
    $resultado["sucursal"]=$sucursal->buscarParaSelect($restaurantesession);
    $resultado["almacen"]=$almacen->buscarParaSelect($restaurantesession);
    $resultado["unidad"]=$unidad->todo($restaurantesession);
    $resultado["id_sucursal"]=$sucursalsession;
    $resultado["id_almacen"]=$almacensession;
    if($idstock!="0"){
        $producto=new PRODUCTO($con);
        $stock=new STOCK($con);
        $resultado["stock"]=$stock->buscarXID($idstock);
        $resultado["producto"]=$producto->buscarXID($resultado["stock"]->Producto_Id);
    }
}
if($proceso==="crearUnidad"){
    $unidad=new UNIDAD($con);
    $text=$_POST["text"];
    if(!$Herramienta->validar("texto y entero", $text)){
        $error="La nueva unidad de medida no puede tener caracteres especiales.";
    }
    if($error===""){
        $unidad->contructor(0, $text, $restaurantesession);
        if(!$resultado=$unidad->insertar()){
            $error="No se pudo registrar la unidad de medida. Intente nuevamente.";
        }else{
            $unidad=new UNIDAD($con);
            $resultado=$unidad->todo($restaurantesession);
        }
    }
}
if($proceso==="registarProducto"){
    $nombre=$_POST["nombre"];
    $cantidad=$_POST["cantidad"];
    $compra=$_POST["compra"];
    $venta=$_POST["venta"];
    $cantmin=$_POST["min"];
    $sucursal=$_POST["sucursal"];
    $fecha=$_POST["fecha"];
    $almacen=$_POST["almacen"];
    $unidad=$_POST["unidad"];
    $tipo=$_POST["tipo"];
    $idstock=$_POST["idstock"];
    $foto=$_POST["fproducto"];
    $almacen=$almacen==="0"?"null":$almacen;
    $sucursal=$sucursal==="0"?"null":$sucursal;
    if(!$Herramienta->validar("texto y entero",$nombre)){
        $error.="<p>El nombre no es valido. No se aceptan caracteres especiales.</p>";
    }
    if(floatval($cantidad)<=0){
        $error.="<p>No ha especificado un cantidad valida.</p>";
    }
    if($unidad==="0"){
        $error.="<p>Selecciones una unidad de medida.</p>";
    }
    if(floatval($compra)<=0){
        $error.="<p>No ha especificado el precio compra.</p>";
    }
    if(floatval($venta)<=0 && $tipo!=="Ingredientes"){
        $error.="<p>No ha especificado el precio venta.</p>";
    }
    if(floatval($cantmin)<=0){
        $error.="<p>La cantidad minimo no puede ser menor o igual a 0.</p>";
    }
    if($sucrusal==="0" && $almacen==="0"){
        $error.="<p>Debe seleccionar el almacen o sucursal donde registrara el producto.</p>";
    }
    if($error===""){
        $stock=new STOCK($con);
        $con->transacion();
        $producto=new PRODUCTO($con);
        $producto->contructor(0, $compra, $venta, $nombre, $unidad, $tipo,$foto);
        $id=0;
        if($idstock==0){
            $id=$producto->insertar();
        }else{
            $stock=$stock->buscarXID($idstock);
            if($producto->modificar($stock->Producto_Id))$id=$stock->Producto_Id;
        }
        if($id===0){

            $error="No se pudo registrar el producto.Intente nuevamente";
        }else{
            $stock->contructor(0, $sucursal, $almacen, $id, $cantidad, $cantmin);
            $stockresult=false;
            if($idstock==0){
                $stockresult=$stock->insertar();
            }else{
                $stock->cantidad=floatval($cantidad)+floatval($stock->cantidad);
                $stockresult=$stock->modificar($idstock);
            }
            if($stockresult){
                $kardex=new KARDEX($con);
                $kardex->contructor(0, $cantidad, $compra, $venta,"EGRESO", $fecha, $id, $personalsession, $sucursal, $almacen, "null");
                if($kardex->insertar()){
                   $con->commit(); 
                }else{
                    $error="No se pudo registrar el producto.Intente nuevamente";
                    $con->rollback();
                }
            }else{
                $error="No se pudo registrar el producto.Intente nuevamente";
                $con->rollback();
            }
        }
    }
}
$reponse = array("error" => $error, "result" => $resultado);
echo $_GET['callback'] . json_encode($reponse);


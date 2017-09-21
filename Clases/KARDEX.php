<?php
class KARDEX {
	var $Id_Kardex;
	var $cantidad;
	var $precio_compra;
	var $precio_venta;
	var $movimiento;
	var $fecha;
	var $Producto_Id;
	var $personal_id;
	var $sucursal_id;
	var $almacen_id;
	var $factura_id;
	var $CON;
	function KARDEX($con) {
		$this->CON=$con;
	}

	function contructor($Id_Kardex, $cantidad, $precio_compra, $precio_venta, $movimiento, $fecha, $Producto_Id, $personal_id, $sucursal_id, $almacen_id, $factura_id){
		$this->Id_Kardex = $Id_Kardex;
		$this->cantidad = $cantidad;
		$this->precio_compra = $precio_compra;
		$this->precio_venta = $precio_venta;
		$this->movimiento = $movimiento;
		$this->fecha = $fecha;
		$this->Producto_Id = $Producto_Id;
		$this->personal_id = $personal_id;
		$this->sucursal_id = $sucursal_id;
		$this->almacen_id = $almacen_id;
		$this->factura_id = $factura_id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$kardex=new KARDEX();
				$kardex->Id_Kardex=$row['Id_Kardex']==null?"":$row['Id_Kardex'];
				$kardex->cantidad=$row['cantidad']==null?"":$row['cantidad'];
				$kardex->precio_compra=$row['precio_compra']==null?"":$row['precio_compra'];
				$kardex->precio_venta=$row['precio_venta']==null?"":$row['precio_venta'];
				$kardex->movimiento=$row['movimiento']==null?"":$row['movimiento'];
				$kardex->fecha=$row['fecha']==null?"":$row['fecha'];
				$kardex->Producto_Id=$row['Producto_Id']==null?"":$row['Producto_Id'];
				$kardex->personal_id=$row['personal_id']==null?"":$row['personal_id'];
				$kardex->sucursal_id=$row['sucursal_id']==null?"":$row['sucursal_id'];
				$kardex->almacen_id=$row['almacen_id']==null?"":$row['almacen_id'];
				$kardex->factura_id=$row['factura_id']==null?"":$row['factura_id'];
				$lista[]=$kardex;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.KARDEX";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.KARDEX where Id_Kardex=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($Id_Kardex){
		$consulta="update eldebatedegusto.KARDEX set Id_Kardex =".$this->Id_Kardex.", cantidad =".$this->cantidad.", precio_compra =".$this->precio_compra.", precio_venta =".$this->precio_venta.", movimiento ='".$this->movimiento."', fecha ='".$this->fecha."', Producto_Id =".$this->Producto_Id.", personal_id =".$this->personal_id.", sucursal_id =".$this->sucursal_id.", almacen_id =".$this->almacen_id.", factura_id =".$this->factura_id." where Id_Kardex=".$Id_Kardex;
		return $this->CON->manipular($consulta);
	}

	function eliminar($Id_Kardex){
		$consulta="delete from eldebatedegusto.KARDEX where Id_Kardex=".$Id_Kardex;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.KARDEX(Id_Kardex, cantidad, precio_compra, precio_venta, movimiento, fecha, Producto_Id, personal_id, sucursal_id, almacen_id, factura_id) values(".$this->Id_Kardex.",".$this->cantidad.",".$this->precio_compra.",".$this->precio_venta.",'".$this->movimiento."','".$this->fecha."',".$this->Producto_Id.",".$this->personal_id.",".$this->sucursal_id.",".$this->almacen_id.",".$this->factura_id.")";
		return $this->CON->manipular($consulta);
	}

}

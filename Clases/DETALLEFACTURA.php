<?php
class DETALLEFACTURA {
	var $factura_id;
	var $cantidad;
	var $plato_id;
	var $Producto_Id;
	var $CON;
	function DETALLEFACTURA($con) {
		$this->CON=$con;
	}

	function contructor($factura_id, $cantidad, $plato_id, $Producto_Id){
		$this->factura_id = $factura_id;
		$this->cantidad = $cantidad;
		$this->plato_id = $plato_id;
		$this->Producto_Id = $Producto_Id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$detallefactura=new DETALLEFACTURA();
				$detallefactura->factura_id=$row['factura_id']==null?"":$row['factura_id'];
				$detallefactura->cantidad=$row['cantidad']==null?"":$row['cantidad'];
				$detallefactura->plato_id=$row['plato_id']==null?"":$row['plato_id'];
				$detallefactura->Producto_Id=$row['Producto_Id']==null?"":$row['Producto_Id'];
				$lista[]=$detallefactura;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.DETALLEFACTURA";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.DETALLEFACTURA(factura_id, cantidad, plato_id, Producto_Id) values(".$this->factura_id.",".$this->cantidad.",".$this->plato_id.",".$this->Producto_Id.")";
		return $this->CON->manipular($consulta);
	}

}

<?php
class DETALLEPEDIDO {
	var $pedido_id;
	var $plato_id;
	var $cantidad;
	var $Producto_Id;
	var $CON;
	function DETALLEPEDIDO($con) {
		$this->CON=$con;
	}

	function contructor($pedido_id, $plato_id, $cantidad, $Producto_Id){
		$this->pedido_id = $pedido_id;
		$this->plato_id = $plato_id;
		$this->cantidad = $cantidad;
		$this->Producto_Id = $Producto_Id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$detallepedido=new DETALLEPEDIDO();
				$detallepedido->pedido_id=$row['pedido_id']==null?"":$row['pedido_id'];
				$detallepedido->plato_id=$row['plato_id']==null?"":$row['plato_id'];
				$detallepedido->cantidad=$row['cantidad']==null?"":$row['cantidad'];
				$detallepedido->Producto_Id=$row['Producto_Id']==null?"":$row['Producto_Id'];
				$lista[]=$detallepedido;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.DETALLEPEDIDO";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.DETALLEPEDIDO(pedido_id, plato_id, cantidad, Producto_Id) values(".$this->pedido_id.",".$this->plato_id.",".$this->cantidad.",".$this->Producto_Id.")";
		return $this->CON->manipular($consulta);
	}

}

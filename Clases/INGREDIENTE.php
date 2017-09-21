<?php
class INGREDIENTE {
	var $plato_id_plato;
	var $Producto_Id_Producto;
	var $cantidad;
	var $CON;
	function INGREDIENTE($con) {
		$this->CON=$con;
	}

	function contructor($plato_id_plato, $Producto_Id_Producto, $cantidad){
		$this->plato_id_plato = $plato_id_plato;
		$this->Producto_Id_Producto = $Producto_Id_Producto;
		$this->cantidad = $cantidad;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$ingrediente=new INGREDIENTE();
				$ingrediente->plato_id_plato=$row['plato_id_plato']==null?"":$row['plato_id_plato'];
				$ingrediente->Producto_Id_Producto=$row['Producto_Id_Producto']==null?"":$row['Producto_Id_Producto'];
				$ingrediente->cantidad=$row['cantidad']==null?"":$row['cantidad'];
				$lista[]=$ingrediente;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.INGREDIENTE";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.INGREDIENTE(plato_id_plato, Producto_Id_Producto, cantidad) values(".$this->plato_id_plato.",".$this->Producto_Id_Producto.",".$this->cantidad.")";
		return $this->CON->manipular($consulta);
	}

}

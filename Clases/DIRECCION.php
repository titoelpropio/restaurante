<?php
class DIRECCION {
	var $id_direccion;
	var $descripcion;
	var $cliente_id;
	var $CON;
	function DIRECCION($con) {
		$this->CON=$con;
	}

	function contructor($id_direccion, $descripcion, $cliente_id){
		$this->id_direccion = $id_direccion;
		$this->descripcion = $descripcion;
		$this->cliente_id = $cliente_id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$direccion=new DIRECCION();
				$direccion->id_direccion=$row['id_direccion']==null?"":$row['id_direccion'];
				$direccion->descripcion=$row['descripcion']==null?"":$row['descripcion'];
				$direccion->cliente_id=$row['cliente_id']==null?"":$row['cliente_id'];
				$lista[]=$direccion;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.DIRECCION";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.DIRECCION where id_direccion=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_direccion){
		$consulta="update eldebatedegusto.DIRECCION set id_direccion =".$this->id_direccion.", descripcion ='".$this->descripcion."', cliente_id =".$this->cliente_id." where id_direccion=".$id_direccion;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_direccion){
		$consulta="delete from eldebatedegusto.DIRECCION where id_direccion=".$id_direccion;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.DIRECCION(id_direccion, descripcion, cliente_id) values(".$this->id_direccion.",'".$this->descripcion."',".$this->cliente_id.")";
		return $this->CON->manipular($consulta);
	}

}

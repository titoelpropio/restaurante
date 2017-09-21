<?php
class REGIONAL {
	var $id_regional;
	var $descripcion;
	var $CON;
	function REGIONAL($con) {
		$this->CON=$con;
	}

	function contructor($id_regional, $descripcion){
		$this->id_regional = $id_regional;
		$this->descripcion = $descripcion;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$regional=new REGIONAL();
				$regional->id_regional=$row['id_regional']==null?"":$row['id_regional'];
				$regional->descripcion=$row['descripcion']==null?"":$row['descripcion'];
				$lista[]=$regional;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.REGIONAL";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.REGIONAL where id_regional=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_regional){
		$consulta="update eldebatedegusto.REGIONAL set id_regional =".$this->id_regional.", descripcion ='".$this->descripcion."' where id_regional=".$id_regional;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_regional){
		$consulta="delete from eldebatedegusto.REGIONAL where id_regional=".$id_regional;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.REGIONAL(id_regional, descripcion) values(".$this->id_regional.",'".$this->descripcion."')";
		return $this->CON->manipular($consulta);
	}

}

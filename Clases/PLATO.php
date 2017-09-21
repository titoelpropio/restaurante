<?php
class PLATO {
	var $id_plato;
	var $nombre;
	var $preparacion;
	var $sucursal_id;
	var $CON;
	function PLATO($con) {
		$this->CON=$con;
	}

	function contructor($id_plato, $nombre, $preparacion, $sucursal_id){
		$this->id_plato = $id_plato;
		$this->nombre = $nombre;
		$this->preparacion = $preparacion;
		$this->sucursal_id = $sucursal_id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$plato=new PLATO();
				$plato->id_plato=$row['id_plato']==null?"":$row['id_plato'];
				$plato->nombre=$row['nombre']==null?"":$row['nombre'];
				$plato->preparacion=$row['preparacion']==null?"":$row['preparacion'];
				$plato->sucursal_id=$row['sucursal_id']==null?"":$row['sucursal_id'];
				$lista[]=$plato;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.PLATO";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.PLATO where id_plato=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_plato){
		$consulta="update eldebatedegusto.PLATO set id_plato =".$this->id_plato.", nombre ='".$this->nombre."', preparacion ='".$this->preparacion."', sucursal_id =".$this->sucursal_id." where id_plato=".$id_plato;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_plato){
		$consulta="delete from eldebatedegusto.PLATO where id_plato=".$id_plato;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.PLATO(id_plato, nombre, preparacion, sucursal_id) values(".$this->id_plato.",'".$this->nombre."','".$this->preparacion."',".$this->sucursal_id.")";
		return $this->CON->manipular($consulta);
	}

}

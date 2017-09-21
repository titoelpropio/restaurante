<?php
class RESTAURANTE {
	var $id_restaurante;
	var $nombre;
	var $razon_social;
	var $logo;
	var $fechaCreacion;
	var $CON;
	function RESTAURANTE($con) {
		$this->CON=$con;
	}

	function contructor($id_restaurante, $nombre, $razon_social, $logo, $fechaCreacion){
		$this->id_restaurante = $id_restaurante;
		$this->nombre = $nombre;
		$this->razon_social = $razon_social;
		$this->logo = $logo;
		$this->fechaCreacion = $fechaCreacion;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$restaurante=new RESTAURANTE();
				$restaurante->id_restaurante=$row['id_restaurante']==null?"":$row['id_restaurante'];
				$restaurante->nombre=$row['nombre']==null?"":$row['nombre'];
				$restaurante->razon_social=$row['razon_social']==null?"":$row['razon_social'];
				$restaurante->logo=$row['logo']==null?"":$row['logo'];
				$restaurante->fechaCreacion=$row['fechaCreacion']==null?"":$row['fechaCreacion'];
				$lista[]=$restaurante;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.RESTAURANTE";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.RESTAURANTE where id_restaurante=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_restaurante){
		$consulta="update eldebatedegusto.RESTAURANTE set id_restaurante =".$this->id_restaurante.", nombre ='".$this->nombre."', razon_social ='".$this->razon_social."', logo ='".$this->logo."', fechaCreacion ='".$this->fechaCreacion."' where id_restaurante=".$id_restaurante;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_restaurante){
		$consulta="delete from eldebatedegusto.RESTAURANTE where id_restaurante=".$id_restaurante;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.RESTAURANTE(id_restaurante, nombre, razon_social, logo, fechaCreacion) values(".$this->id_restaurante.",'".$this->nombre."','".$this->razon_social."','".$this->logo."','".$this->fechaCreacion."')";
		return $this->CON->manipular($consulta);
	}

}

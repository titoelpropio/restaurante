<?php
class TIPOPLATO {
	var $idtipoplato;
	var $descripcion;
	var $plato_id;
	var $CON;
	function TIPOPLATO($con) {
		$this->CON=$con;
	}

	function contructor($idtipoplato, $descripcion, $plato_id){
		$this->idtipoplato = $idtipoplato;
		$this->descripcion = $descripcion;
		$this->plato_id = $plato_id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$tipoplato=new TIPOPLATO();
				$tipoplato->idtipoplato=$row['idtipoplato']==null?"":$row['idtipoplato'];
				$tipoplato->descripcion=$row['descripcion']==null?"":$row['descripcion'];
				$tipoplato->plato_id=$row['plato_id']==null?"":$row['plato_id'];
				$lista[]=$tipoplato;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.TIPOPLATO";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.TIPOPLATO where idtipoplato=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($idtipoplato){
		$consulta="update eldebatedegusto.TIPOPLATO set idtipoplato =".$this->idtipoplato.", descripcion ='".$this->descripcion."', plato_id =".$this->plato_id." where idtipoplato=".$idtipoplato;
		return $this->CON->manipular($consulta);
	}

	function eliminar($idtipoplato){
		$consulta="delete from eldebatedegusto.TIPOPLATO where idtipoplato=".$idtipoplato;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.TIPOPLATO(idtipoplato, descripcion, plato_id) values(".$this->idtipoplato.",'".$this->descripcion."',".$this->plato_id.")";
		return $this->CON->manipular($consulta);
	}

}

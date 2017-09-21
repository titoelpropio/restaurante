<?php
class MESA {
	var $id_mesa;
	var $nromesa;
	var $estado;
	var $Ambiente_id;
	var $CON;
	function MESA($con) {
		$this->CON=$con;
	}

	function contructor($id_mesa, $nromesa, $estado, $Ambiente_id){
		$this->id_mesa = $id_mesa;
		$this->nromesa = $nromesa;
		$this->estado = $estado;
		$this->Ambiente_id = $Ambiente_id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$mesa=new MESA();
				$mesa->id_mesa=$row['id_mesa']==null?"":$row['id_mesa'];
				$mesa->nromesa=$row['nromesa']==null?"":$row['nromesa'];
				$mesa->estado=$row['estado']==null?"":$row['estado'];
				$mesa->Ambiente_id=$row['Ambiente_id']==null?"":$row['Ambiente_id'];
				$lista[]=$mesa;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.MESA";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.MESA where id_mesa=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_mesa){
		$consulta="update eldebatedegusto.MESA set id_mesa =".$this->id_mesa.", nromesa ='".$this->nromesa."', estado ='".$this->estado."', Ambiente_id =".$this->Ambiente_id." where id_mesa=".$id_mesa;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_mesa){
		$consulta="delete from eldebatedegusto.MESA where id_mesa=".$id_mesa;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.MESA(id_mesa, nromesa, estado, Ambiente_id) values(".$this->id_mesa.",'".$this->nromesa."','".$this->estado."',".$this->Ambiente_id.")";
		return $this->CON->manipular($consulta);
	}

}

<?php
class PEDIDO {
	var $id_pedido;
	var $fecha;
	var $estado;
	var $mesa_id;
	var $personal_id;
	var $nro;
	var $cliente_id;
	var $CON;
	function PEDIDO($con) {
		$this->CON=$con;
	}

	function contructor($id_pedido, $fecha, $estado, $mesa_id, $personal_id, $nro, $cliente_id){
		$this->id_pedido = $id_pedido;
		$this->fecha = $fecha;
		$this->estado = $estado;
		$this->mesa_id = $mesa_id;
		$this->personal_id = $personal_id;
		$this->nro = $nro;
		$this->cliente_id = $cliente_id;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$pedido=new PEDIDO();
				$pedido->id_pedido=$row['id_pedido']==null?"":$row['id_pedido'];
				$pedido->fecha=$row['fecha']==null?"":$row['fecha'];
				$pedido->estado=$row['estado']==null?"":$row['estado'];
				$pedido->mesa_id=$row['mesa_id']==null?"":$row['mesa_id'];
				$pedido->personal_id=$row['personal_id']==null?"":$row['personal_id'];
				$pedido->nro=$row['nro']==null?"":$row['nro'];
				$pedido->cliente_id=$row['cliente_id']==null?"":$row['cliente_id'];
				$lista[]=$pedido;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.PEDIDO";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.PEDIDO where id_pedido=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_pedido){
		$consulta="update eldebatedegusto.PEDIDO set id_pedido =".$this->id_pedido.", fecha ='".$this->fecha."', estado ='".$this->estado."', mesa_id =".$this->mesa_id.", personal_id =".$this->personal_id.", nro =".$this->nro.", cliente_id =".$this->cliente_id." where id_pedido=".$id_pedido;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_pedido){
		$consulta="delete from eldebatedegusto.PEDIDO where id_pedido=".$id_pedido;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.PEDIDO(id_pedido, fecha, estado, mesa_id, personal_id, nro, cliente_id) values(".$this->id_pedido.",'".$this->fecha."','".$this->estado."',".$this->mesa_id.",".$this->personal_id.",".$this->nro.",".$this->cliente_id.")";
		return $this->CON->manipular($consulta);
	}

}

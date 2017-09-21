<?php
class CLIENTE {
	var $id_cliente;
	var $nombre;
	var $ci;
	var $cuenta;
	var $contrasena;
	var $correo;
	var $telefono;
	var $CON;
	function CLIENTE($con) {
		$this->CON=$con;
	}

	function contructor($id_cliente, $nombre, $ci, $cuenta, $contrasena, $correo, $telefono){
		$this->id_cliente = $id_cliente;
		$this->nombre = $nombre;
		$this->ci = $ci;
		$this->cuenta = $cuenta;
		$this->contrasena = $contrasena;
		$this->correo = $correo;
		$this->telefono = $telefono;
	}

	function rellenar($resultado){
		if ($resultado->num_rows > 0) {
			$lista=array();
			while($row = $resultado->fetch_assoc()) {
				$cliente=new CLIENTE();
				$cliente->id_cliente=$row['id_cliente']==null?"":$row['id_cliente'];
				$cliente->nombre=$row['nombre']==null?"":$row['nombre'];
				$cliente->ci=$row['ci']==null?"":$row['ci'];
				$cliente->cuenta=$row['cuenta']==null?"":$row['cuenta'];
				$cliente->contrasena=$row['contrasena']==null?"":$row['contrasena'];
				$cliente->correo=$row['correo']==null?"":$row['correo'];
				$cliente->telefono=$row['telefono']==null?"":$row['telefono'];
				$lista[]=$cliente;
			}
			return $lista;
		}else{
			return null;
		}
	}

	function todo(){
		$consulta="select * from eldebatedegusto.CLIENTE";
		$result=$this->CON->consulta($consulta);
		return $this->rellenar($result);
	}


	function buscarXID($id){
		$consulta="select * from eldebatedegusto.CLIENTE where id_cliente=$id";
		$result=$this->CON->consulta($consulta);
		$empresa=$this->rellenar($result);
		if($empresa==null){
			return null;
		}
return $empresa[0];
	}

	function modificar($id_cliente){
		$consulta="update eldebatedegusto.CLIENTE set id_cliente =".$this->id_cliente.", nombre ='".$this->nombre."', ci ='".$this->ci."', cuenta ='".$this->cuenta."', contrasena ='".$this->contrasena."', correo ='".$this->correo."', telefono ='".$this->telefono."' where id_cliente=".$id_cliente;
		return $this->CON->manipular($consulta);
	}

	function eliminar($id_cliente){
		$consulta="delete from eldebatedegusto.CLIENTE where id_cliente=".$id_cliente;
		return $this->CON->manipular($consulta);
	}

	function insertar(){
		$consulta="insert into eldebatedegusto.CLIENTE(id_cliente, nombre, ci, cuenta, contrasena, correo, telefono) values(".$this->id_cliente.",'".$this->nombre."','".$this->ci."','".$this->cuenta."','".$this->contrasena."','".$this->correo."','".$this->telefono."')";
		return $this->CON->manipular($consulta);
	}

}

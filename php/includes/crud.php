<?php 

class Crud{
	public $insertInto;
	public $insertColumns;
	public $insertValues;
	public $mensaje;

	public $verifi_unsername;
	public $columna_evaluar;
	public $dato_evaluado;

	public $select;
	public $from;
	public $condition;
	public $rows;
	public $username;

	public $update;
	public $set;

	public $deleteFrom;
	
	public function Create() {
		$model = new Conexion;
		$conexion = $model->conectar();
		$insertInto = $this->insertInto;
		$insertColumns = $this->insertColumns;
		$insertValues = $this->insertValues;
		$columna_evaluar = $this->columna_evaluar;
		$dato_evaluado = $this->dato_evaluado;

		if ($this->verifi_unsername) {
			$sql= "SELECT * from $insertInto where $columna_evaluar= '".$dato_evaluado."'";
			$consulta = $conexion->prepare($sql);
			if ($consulta) {
				$consulta->execute();
				if ($consulta->rowCount() > 0) {
					$this->mensaje = 1;
					return;
				}
			}
		}
		$sql = "INSERT INTO $insertInto ($insertColumns) VALUES ($insertValues)";
		$consulta = $conexion->prepare($sql);
		if (!$consulta) {
			$this->mensaje = 0;
		} else {
			$consulta->execute();
			$this->mensaje = 2;
		}
		return;
	}

	public function login() {
		session_start();
		$model = new Conexion;
		$conexion = $model->conectar();
		$select = $this->select;
		$username = $this->username;
		$from = $this->from;
		$condition = $this->condition;
		$rows = $this->rows;
		if ($condition != '') {
			$condition = " WHERE " . $condition;
		}
		$sql = "SELECT $select FROM $from $condition";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();

		if($resultado = $consulta->fetchAll()) {
			$_SESSION['u_usuario'] = $username;
			$_SESSION['u_privilegios'] = $resultado[0][7];
			$this->mensaje = 1;
		}else{
			$this->mensaje = 0;
		}
	}

	public function Read() {
		$model = new Conexion;
		$conexion = $model->conectar();
		$select = $this->select;
		$from = $this->from;
		$condition = $this->condition;
	
		$sql = "SELECT $select FROM $from $condition";
		$consulta = $conexion->prepare($sql);
		$consulta->execute();

		while ($filas = $consulta->fetch()) {
			$this->rows[] = $filas;
		}
	}

	public function Update() {
		$model = new Conexion;
		$conexion = $model->conectar();
		$update = $this->update;
		$set = $this->set;
		$condition = $this->condition;

		$sql = "UPDATE $update SET $set $condition";
		$consulta = $conexion->prepare($sql);
		if ($consulta) {
			$consulta->execute();
		}
	}

	public function Delete() {
		$model = new Conexion;
		$conexion = $model->conectar();
		$deleteFrom = $this->deleteFrom;
		$condition = $this->condition;
		
		$sql = "DELETE FROM $deleteFrom $condition";
		$consulta = $conexion->prepare($sql);
		if ($consulta) {
			$consulta->execute();
		}
	}
}
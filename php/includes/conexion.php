<?php 
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ALL);
ini_set('display_errors', 'On');
class Conexion{
	public function conectar() {
		$usuario = 'root';
		$password = 'martinez2412';
		$host = 'localhost:3306';
		$dbname = 'dbcarrito';
		return $conexion = new PDO("mysql:host=$host;dbname=$dbname;", $usuario, $password);
	}
}
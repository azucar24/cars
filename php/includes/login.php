<?php 
require_once('conexion.php');
require_once('crud.php');

$username = htmlspecialchars($_POST['username']);
$password = sha1($_POST['password']);

$model = new Crud;
$model->select = "*";
$model->from = "usuarios";
$model->condition = "username = '".$username."' AND password = '".$password."'";
$model->username = $username;
$model->login();
$mensaje = $model->mensaje;

echo $mensaje;

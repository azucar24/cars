<?php 
require_once('conexion.php');
require_once('crud.php');
$nombre_ap = htmlspecialchars($_POST['nombre_ap']);
$username = htmlspecialchars($_POST['username']);
$email = htmlspecialchars($_POST['email']);
$dui = htmlspecialchars($_POST['dui']);
$departamento = htmlspecialchars($_POST['departamento']);
$password = sha1($_POST['password']);

$model = new Crud;
$model->insertInto = 'usuarios';
$model->insertColumns = 'nombre_ap, username, email, dui, departamento, password, privilegios';
$model->insertValues = "'$nombre_ap', '$username', '$email', '$dui', '$departamento', '$password', 0";
$model->verifi_unsername = true;
$model->columna_evaluar = 'username';
$model->dato_evaluado = $username;
$model->Create();
$mensaje = $model->mensaje;


echo $mensaje;

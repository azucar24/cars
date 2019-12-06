<?php 
session_start();
unset($_SESSION['u_usuario']); 
unset($_SESSION['u_privilegios']);
header('Location: ../../index.php');
?>
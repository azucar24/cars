<?php 
session_start();
if (isset($_SESSION['u_usuario'])) {
	if ($_SESSION['u_privilegios'] == 2 OR $_SESSION['u_privilegios'] == 1) {
		header('Location: /cars/admin.php');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Auto-Ventas</title>
	<meta charset="utf-8">
	<?php include_once('php/includes/librerias.php');?>
</head>
<body>
	<?php 
	$section = 'index';
	include_once('php/includes/header.php');
	?>
	
	<?php include_once('php/includes/footer.php');?>
</body>
</html>
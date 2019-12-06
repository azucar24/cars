<?php 
session_start();
if (isset($_SESSION['u_usuario'])) {
	header('Location: userok.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<?php include_once('php/includes/librerias.php');?>
	<script type="text/javascript">
		$.validator.setDefaults({
			submitHandler: function() {
				login();
			}
		});
	</script>
</head>
<body>
	<?php 
	$section = 'login';
	include_once('php/includes/header.php');
	?>
	<div id="main">
		<div class="container-fluid" style="margin-top: 50px;">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-info text-center" style="margin-bottom: 80px;">
			    		<div class="panel-heading"><h4>Regístrate</h4></div>
			    		<div class="panel-body">

			    			<div class="container-fluid">
			    				<form id="form_login" method="post">
				    				<div class="form-group">
									    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nombre de usuario">
	  								</div>
	  								<div class="form-group">
				    					<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
	  								</div>
	  								
	  								<button type="submit" class="btn btn-primary" style="width: 100%;">Iniciar sesión</button>
								</form>

			    			</div>
			    		</div>
			  		</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once('php/includes/footer.php');?>
</body>
</html>
<?php 
session_start();
if (isset($_SESSION['u_usuario'])) {
	header('Location: userok.php');
}

require_once('php/includes/conexion.php');
require_once('php/includes/crud.php');

$model = new Crud;
$model->select = "*";
$model->from = "zona";
$model->Read();
$zonas = $model->rows;

?>
<!DOCTYPE html>
<html>
<head>
	<title>Registro</title>
	<meta charset="utf-8">
	<?php include_once('php/includes/librerias.php');?>
	<script type="text/javascript">
		$.validator.setDefaults({
			submitHandler: function() {
				registrarUsuario();
			}
		});
	</script>
</head>
<body>
	<?php 
	$section = 'register';
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
			    				<form id="form_register" method="post">
				    				<div class="form-group">
									    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre y Apellidos">
	  								</div>
	  								<div class="form-group">
									    <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nombre de Usuario">
	  								</div>
	  								<div class="form-group">
				    					<input type="text" name="email" id="email" class="form-control" placeholder="Correo Electrónico">
	  								</div>
	  								<div class="form-group">
				    					<input type="text" name="dui" id="dui" class="form-control" placeholder="Dui">
	  								</div>
	  								<div class="form-group">
	  									<select id="departamento" class="form-control" name="departamento" required="">
	  										<option selected="true" hidden="true" value="" disabled>-- Departamento --</option>
	  										Departamento --</option>
	  										<?php 
	  										foreach ($zonas as $zona) {
	  											echo "<option value='".$zona['zona']."'>".$zona['zona']."</option>";
	  										}
	  										?>
	  									</select>
	  								</div>
	  								<div class="form-group">
				    					<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
	  								</div>
	  								<div class="form-group">
				    					<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirmar contraseña">
	  								</div>
	  								<button type="submit" class="btn btn-primary" style="width: 100%;">Registrarme</button>
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
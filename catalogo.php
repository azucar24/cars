<?php 
session_start();
if (isset($_SESSION['u_usuario'])) {
	$usuario = $_SESSION['u_usuario'];
	if ($_SESSION['u_privilegios'] == 1) {
		header('Location: /cars/vendedor.php');
	} else if ($_SESSION['u_privilegios'] == 2) {
		header('Location: /cars/admin.php');
	}
} else {
	header('Location: /cars');
}

require_once('php/includes/conexion.php');
require_once('php/includes/crud.php');

$model = new Crud;
$model->select = "*";
$model->from = "autos";
$model->Read();
$filas = $model->rows;
$total = count($filas);


if (isset($_POST['pulsado_save'])) {
	$id = $_POST['id'];
	$id_usuario;

	//para obtener el id del usuario
	$model = new Crud;
	$model->select = "*";
	$model->from = "usuarios";
	$model->condition = " WHERE username='$usuario'";
	$model->Read();
	$filas2 = $model->rows;
	$id_usuario = $filas2[0]['id_usuario'];

	//para saber si ya esiste el auto guardado
	$model = new Crud;
	$model->select = "*";
	$model->from = "autos_guardados";
	$model->condition = " WHERE id_auto=$id AND id_usuario=$id_usuario";
	$model->Read();
	$filas3 = $model->rows;

	if (count($filas3) == 0) {
		if (count($filas2) > 0) {

			$model = new Crud();
			$model->insertInto = 'autos_guardados';
			$model->insertColumns = 'id_usuario, id_auto';
			$model->insertValues = "$id_usuario, $id";
			$model->Create();
			$mensaje = "<script>";
			$mensaje .= "alert('Guardo este auto.');";
			$mensaje .= "document.location.href = document.location.href;";
			$mensaje .= "</script>";
			echo $mensaje;
		}
	} else {
		$mensaje = "<script>";
		$mensaje .= "alert('Error, el auto ya esta en la lista de deseos.');";
		$mensaje .= "document.location.href = document.location.href;";
		$mensaje .= "</script>";
		echo $mensaje;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo "Ususario " . $_SESSION['u_usuario']?></title>
	<meta charset="utf-8">
	<?php include_once('php/includes/librerias.php');?>
	<style type="text/css">
		.targeta {
			background: #cecbcb;
			position: relative;
			width: 100%;
			height: 200px;
			border-radius: 10px;
			border: 2px solid #000;
		}

		.targeta img {
			border-radius: 10px;
		}

		.regilla {
			position: absolute;
			background: rgba(0,0,0,0.5);
			width: 80%;
			bottom: 0;
			left: 0;
			padding: 5px;
		}

		.regilla div {
			width: 50%;
			float: left;
			color: #fff;
		}

		.targeta .btn_agragar_fav {
			position: absolute;
			bottom: 0;
			right: 0;
			
		}

		#form_save button {
			border-bottom-right-radius: 10px;
		}
	</style>
</head>
<body>
	<?php 
	$section = 'catalogo';
	include_once('php/includes/header.php');
	?>
	
	<div id="main">
		<div class="container-fluid">
			<div class="col-md-10 col-md-offset-1 col-md-12" style="margin-top: 20px;">
				<h1>Catalogo de ventas</h1>
				<?php 
				$contador = 0;
				if ($total == 0) {
				?>
				<div class="alert alert-danger">
  					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  					<strong>Ooops!</strong> Al parecer no hay ningún auto registrado.
				</div>
				<?php
				} else {
					echo "<div class='row'>";
					foreach ($filas as $fila) {
						if ($fila['stock'] > 0) {
							if ($contador % 3 == 0) {
							echo "<div class='row' style='margin-top:20px;'>";
							}
						?>
						<div class="col-md-4 col-sm-4" style="margin-top: 20px;">
							<div class="targeta">
								<img src="<?php echo $fila['img'] ?>" width="100%" height="100%">
								<div class="regilla">
									<div><?php echo "<b>Marca: </b>" . $fila['marca'] ?></div>
									<div><?php echo "<b>Modelo: </b>" . $fila['modelo'] ?></div>
									<div><?php echo "<b>Precio: </b> $".$fila['precio'] ?></div>
									<div><?php echo "<b>Cantidad Disp.</b> " . $fila['stock']; ?></div>
								</div>
								<div class='btn_agragar_fav'>
									<form method="post" id="form_save" action="<?php echo $_SERVER['PHP_SELF'];?>">
										<input type="hidden" name="id" value="<?php echo $fila['id_auto'] ?>">
										<input type="hidden" name="pulsado_save" value="pulsado_save">
										<button type="submit" class="btn btn-info"><span class="icon-plus-circle" style='font-size: 30px;'></span></button>
									</form>
								</div>
							</div>
						</div>
						<?php
						$contador++;
						if ($contador % 3 == 0) {
							echo "</div>";
						}
						}
					}
				}
				?>
			</div>
		</div>
	</div>
</body>
</html>
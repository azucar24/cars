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

$username = $_SESSION['u_usuario'];
$model = new Crud;
$model->select = "*";
$model->from = "usuarios";
$model->condition = " WHERE username='$username'";
$model->Read();
$filas = $model->rows;
$id_usuario = $filas[0]['id_usuario'];

//SELECT * FROM autos WHERE id_auto IN ( SELECT id_auto FROM autos_guardados WHERE id_usuario = 13)
$model = new Crud;
$model->select = "*";
$model->from = "autos";
$model->condition = " WHERE id_auto IN ( SELECT id_auto FROM autos_guardados WHERE id_usuario=$id_usuario) ";
$model->Read();
$filas = $model->rows;
$total = count($filas);

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
	$section = 'saved';
	include_once('php/includes/header.php');
	?>
	
	<div id="main">
		<div class="container-fluid">
			<div class="col-md-10 col-md-offset-1 col-md-12" style="margin-top: 20px;">
				<h1>Autos guardados</h1>
				<?php 
				$contador = 0;
				if ($total == 0) {
				?>
				<div class="alert alert-danger">
  					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  					<strong>Ooops!</strong> Al parecer no has guradado ningun auto en tu lista de deseos.
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
									<button type="submit" class="btn btn-info comprar_auto"><span class="icon-money" style="font-size: 30px;"></span></button>
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
	<script type="text/javascript">
		$(".comprar_auto").on("click", function() {
			alert('Para comprar este auto, acérquese a una de nuestras sucursales mas sercanas, y pida informacion a nuestros');
		});
	</script>
</body>
</html>
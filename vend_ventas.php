<?php 
session_start();
if (isset($_SESSION['u_usuario'])) {
	$usuario = $_SESSION['u_usuario'];
	if ($_SESSION['u_privilegios'] == 2) {
		header('Location: /cars/admin.php');
	} else if ($_SESSION['u_privilegios'] == 0) {
		header('Location: /cars/userok.php');
	}
} else {
	header('Location: /cars/');
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

$model = new Crud;
$model->select = "*";
$model->from = "autos";
$model->condition = " WHERE id_auto IN ( SELECT id_auto FROM ventas WHERE id_vendedor=$id_usuario) ";
$model->Read();
$filas = $model->rows;
$total = count($filas);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AM-ADMIN</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/iconmoon/style.css">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
<style type="text/css">
	#chart_wrap, #chart_wrap2, #chart_wrap3 {
    	border:1px solid gray;
		position: relative;
		padding-bottom: 100%;
		height: 0;
	}
	#chart, #chart2, #chart3 {
		position: absolute;
		top: 0;
		left: 0;
		width:90%;
		height:90%;
	}

	input.error, textarea.error, select.error {
		border: 1px dotted red;
	}

	label.error {
		display: none!important;
	}
</style>
</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>AM</span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg><?php echo $_SESSION['u_usuario'];?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="php/includes/cerrar_session.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li><a href="vendedor.php"><span class="icon-automobile icono"></span> Vender Autos</a></li>
			<li class="active"><a href="vend_ventas.php"><span class="icon-money"></span> Autos Vendidos</a></li>
			<li role="presentation" class="divider"></li>
		</ul>

	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Autos vendidos</h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-md-12" style="margin-top: 20px;">
				<?php 
				if ($total == 0) {
				?>
				<div class="alert alert-danger">
  					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  					<strong>Ooops!</strong> Al parecer no ha realizado ninguna venta.
				</div>
				<?php
				} else {
				?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Año</th>
							<th>Precio</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($filas as $fila) {
							echo '<tr>';
							echo '<td>'.$fila['marca'].'</td>';
							echo '<td>'.$fila['modelo'].'</td>';
							echo '<td>'.$fila['anio'].'</td>';
							echo '<td>$'.$fila['precio'].'</td>';
							echo '</tr>';
						}

						?>
					</tbody>
				</table>
				<?php
				}
				?>
			</div>
		</div>
		<!-- Modal -->
  		<div class="modal fade" id="modalRegistroAuto" role="dialog">
    		<div class="modal-dialog">
      			<div class="modal-content">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Registrar Auto</h4>
        			</div>
        			<div class="modal-body">
        				<div class="container-fluid">
	          				<form class="form-horizontal" id="form_registrar_auto" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="nombre">Nombre</label>
	    							<div class="col-sm-9">
	    								<input type="text" class="form-control" id="nombre" name="nombre">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="marca">Marca</label>
	    							<div class="col-sm-9">
	    								<input type="text" class="form-control" id="marca" name="marca">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="modelo">Modelo</label>
	    							<div class="col-sm-9">
	    								<input type="text" class="form-control" id="modelo" name="modelo">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="anio">Año</label>
	    							<div class="col-sm-9">
	    								<input type="number" class="form-control" id="anio" name="anio">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="precio">Precio</label>
	    							<div class="col-sm-9">
	    								<input type="number" class="form-control" id="precio" name="precio">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="stock">Cantidad en stock</label>
	    							<div class="col-sm-9">
	    								<input type="number" class="form-control" id="stock" name="stock">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="tipo">Tipo</label>
	    							<div class="col-sm-9">
	    								<select class="form-control" id="tipo" name="tipo">
	    									<option selected="true" disabled="true" hidden="true" value="">-- Selecciones categoria -- </option>
	    									<option value="Automóvil de turismo">Automóvil de turismo</option>
	    									<option value="Automóvil deportivo">Automóvil deportivo</option>
	    									<option value="Monovolumen">Monovolumen</option>
	    									<option value="Todoterreno">Todoterreno</option>
	    									<option value="Vehículo deportivo utilitario">Vehículo deportivo utilitario</option>
	    									<option value="Furgoneta">Furgoneta</option>
	    									<option value="Camioneta">Camioneta</option>
	    								</select>
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="description">Descripción</label>
	    							<div class="col-sm-9">
	    								<textarea class="form-control" id="description" name="description"></textarea>
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for="imagen" name="imagen">Imagen</label>
	    							<div class="col-sm-9">
	    								<input type="file" id="imagen" name="imagen">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<label class="col-sm-3 control-label" for=""></label>
	    							<div class="col-sm-9">
	    								<input type="hidden" name="enviado">
	    								<button type="submit" class="btn btn-success" id="btn_registrar_auto">Registrar</button>
	  								</div>
	  							</div>
							</form>
						</div>
        			</div>
        			<div class="modal-footer">
          				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			</div>
      			</div>
    		</div>
  		</div>
  		<?php 
  		if ($total > 0) {
  			# code...
	  		foreach ($filas as $fila) {
	  		?>
	  		<div class="modal fade" id="modalEditar<?php echo $fila['id_auto'];?>" role="dialog">
	    		<div class="modal-dialog">
	      			<div class="modal-content">
	        			<div class="modal-header">
	          				<button type="button" class="close" data-dismiss="modal">&times;</button>
	          				<h4 class="modal-title">Registrar Auto</h4>
	        			</div>
	        			<div class="modal-body">
	        				<div class="container-fluid">
		          				<form class="form-horizontal" id="form_registrar_auto" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="nombre">Nombre</label>
		    							<div class="col-sm-9">
		    								<input type="text" class="form-control" value="<?php echo $fila['nombre'];?>" id="nombre" name="nombre">
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="marca">Marca</label>
		    							<div class="col-sm-9">
		    								<input type="text" class="form-control" value="<?php echo $fila['marca'];?>" id="marca" name="marca">
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="modelo">Modelo</label>
		    							<div class="col-sm-9">
		    								<input type="text" class="form-control" value="<?php echo $fila['modelo'];?>" id="modelo" name="modelo">
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="anio">Año</label>
		    							<div class="col-sm-9">
		    								<input type="number" class="form-control" value="<?php echo $fila['anio'];?>" id="anio" name="anio">
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="precio">Precio</label>
		    							<div class="col-sm-9">
		    								<input type="number" class="form-control" value="<?php echo $fila['precio'];?>" id="precio" name="precio">
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="stock">Cantidad en stock</label>
		    							<div class="col-sm-9">
		    								<input type="number" value="<?php echo $fila['stock'];?>" class="form-control" id="stock" name="stock">
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for="description">Descripción</label>
		    							<div class="col-sm-9">
		    								<textarea class="form-control" id="description" name="description"><?php echo $fila['descripcion'];?></textarea>
		  								</div>
		  							</div>
		  							<div class="form-group">
		    							<label class="col-sm-3 control-label" for=""></label>
		    							<div class="col-sm-9">
		    								<input type="hidden" name="enviado_edit">
		    								<input type="hidden" name="id" value="<?php echo $fila['id_auto'];?>">
		    								<button type="submit" class="btn btn-success" id="btn_registrar_auto">Actualizar</button>
		  								</div>
		  							</div>
								</form>
							</div>
	        			</div>
	        			<div class="modal-footer">
	          				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        			</div>
	      			</div>
	    		</div>
	  		</div>
  		<?php
  		}
  		}
  		?>
	</div>	<!--/.main-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>	
	<script type="text/javascript" src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/admin.js"></script>
	<script>
		$(".btn_actualizar").on('click', function(event) {
			event.preventDefault();
		});

		$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
		
		$.validator.setDefaults({
			submitHandler: function() {
				login();
			}
		});
	</script>	
</body>

</html>

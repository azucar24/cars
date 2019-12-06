<?php 
session_start();
if (isset($_SESSION['u_usuario'])) {
	$usuario = $_SESSION['u_usuario'];
	if ($_SESSION['u_privilegios'] == 1) {
		header('Location: /cars/vendedor.php');
	} else if ($_SESSION['u_privilegios'] == 0) {
		header('Location: /cars/userok.php');
	}
} else {
	header('Location: /cars/');
}

require_once('php/includes/conexion.php');
require_once('php/includes/crud.php');

$model = new Crud;
$model->select = "*";
$model->from = "usuarios";

$privi = "10";
if (isset($_GET['users'])) {
	$usuarios = $_GET['users'];
	if ($usuarios != "clientes" AND $usuarios != "vendedores" AND $usuarios != "gerencia") {
		header('Location: /progra/');
	}
	if ($usuarios == "clientes") {
		$privi = 0;
	} else if ($usuarios == "vendedores") {
		$privi = 1;
	} else if ($usuarios == "gerencia") {
		$privi = 2;
	}

	$model->condition = " WHERE privilegios=$privi";
}

$model->Read();
$filas = $model->rows;
$total = count($filas);

if (isset($_POST['form_suspender'])) {
	$id = $_POST['id'];

	$model = new Crud();
	$model->update = 'usuarios';
	$model->set = "estado=0";
	$model->condition = " WHERE id_usuario=$id";
	$model->Update();
	$mensaje = "<script>";
	$mensaje .= "alert('El usuario ha sido suspendido.');";
	$mensaje .= "document.location.href = document.location.href;";
	$mensaje .= "</script>";
	echo $mensaje;
}

if (isset($_POST['form_activar'])) {
	$id = $_POST['id'];

	$model = new Crud();
	$model->update = 'usuarios';
	$model->set = "estado=1";
	$model->condition = " WHERE id_usuario=$id";
	$model->Update();
	$mensaje = "<script>";
	$mensaje .= "alert('El usuario ha sido reactivado.');";
	$mensaje .= "document.location.href = document.location.href;";
	$mensaje .= "</script>";
	echo $mensaje;
}

if (isset($_POST['frm_reg_ven_sent'])) {
	
	$nombre_ap = htmlspecialchars($_POST['nombre']);
	$username = htmlspecialchars($_POST['usuario']);
	$email = htmlspecialchars($_POST['email']);
	$dui = htmlspecialchars($_POST['dui']);
	$departamento = htmlspecialchars($_POST['departamento']);
	$password = sha1($_POST['password']);

	$model = new Crud;
	$model->insertInto = 'usuarios';
	$model->insertColumns = 'nombre_ap, username, email, dui, departamento, password, privilegios';
	$model->insertValues = "'$nombre_ap', '$username', '$email', '$dui', '$departamento', '$password', 1";
	$model->verifi_unsername = true;
	$model->columna_evaluar = 'username';
	$model->dato_evaluado = $username;
	$model->Create();

}

$model = new Crud;
$model->select = "*";
$model->from = "zona";
$model->Read();
$zonas = $model->rows;

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
							<li><a href="php/includes/cerrar_session.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Cerrar Session</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
			<li class="">
			<a href="admin.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Tablero</a></li>
			<li><a href="ad_autos_venta.php"><span class="icon-automobile icono"></span>Autos en venta</a></li>
			<li class="active"><a href="ad_usuarios.php"><span class="icon-users icono"></span>Usuarios</a></li>
			<li><a href="ad_puntos_centas.php"><span class="icon-location icono"></span>Puntos de venta</a></li>
			<li role="presentation" class="divider"></li>
		</ul>

	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Usuarios Registrados</h1>
			</div>
		</div><!--/.row-->
		
		<?php require_once("php/includes/encabezado_admin.php");?>

		<div class="row">
			<div class="col-md-12" style="margin-top: 20px;">
			<div class="form-group">
				<button class="btn btn-primary" data-toggle="modal" data-target="#modalRegistroVendedor"><span class="icon-add-user"></span> Agregar Vendedor</button>
			</div>
			<div class="form-group">
				<select class="form-control" id="select_categorias_u">
					<option selected="" value="i">Todos los Usuarios</option>
					<option <?php if ($privi == 0) { echo "selected"; }?> value="0">Clientes</option>
					<option <?php if ($privi == 1) { echo "selected"; }?> value="1">Vendedores</option>
					<option <?php if ($privi == 2) { echo "selected"; }?> value="2">Gerencia</option>
				</select>
			</div>
				<?php 
				if ($total == 0) {
				?>
				<div class="alert alert-danger">
  					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  					<strong>Ooops!</strong> Al parecer no hay ningún usuario registrado en esta categoria.
				</div>
				<?php
				} else {
				?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre y Apellido</th>
							<th>Nombre de Usuario</th>
							<th>email</th>
							<th>Dui</th>
							<th>Departamento</th>
							<th>Privilegios</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($filas as $fila) {
							echo '<tr>';
							echo '<td>'.$fila['nombre_ap'].'</td>';
							echo '<td>'.$fila['username'].'</td>';
							echo '<td>'.$fila['email'].'</td>';
							echo '<td>'.$fila['dui'].'</td>';
							echo '<td>'.$fila['departamento'].'</td>';
							if ($fila['privilegios'] == 0) {
								$privilegio = "Cliente";
							} else if ($fila['privilegios'] == 1) {
								$privilegio = "Vendedor";
							} else {
								$privilegio = "Gerente";
							}
							echo '<td>'.$privilegio.'</td>';
							$estado = $fila['estado'];
							if ($fila['privilegios'] != 2) {
								if ($estado == '0') {
								echo '<td><form class="form-horizontal" id="form_activar_user" method="post" action="'.$_SERVER["PHP_SELF"].'"><input type="hidden" name="id" value="'.$fila['id_usuario'].'"><input type="hidden" name="form_activar"><input type="submit" class="btn btn-success btn_activar_u" style="margin-right:5px;" value="Activar"></form></td>';
								} else {
									echo '<td><form class="form-horizontal" id="form_desactivar_user" method="post" action="'.$_SERVER["PHP_SELF"].'"><input type="hidden" name="id" value="'.$fila['id_usuario'].'"><input type="hidden" name="form_suspender"><input type="submit" class="btn btn-danger btn_suspender_u" style="margin-right:5px;" value="Suspender"></form></td>';
								}
							} else {
								echo "<td> -- -- -- </td>";
							} 

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
  		<div class="modal fade" id="modalRegistroVendedor" role="dialog">
    		<div class="modal-dialog">
      			<div class="modal-content">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Registrar Vendedor</h4>
        			</div>
        			<div class="modal-body">
        				<div class="container-fluid">
	          				<form class="form-horizontal" id="form_registrar_vendedor" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre y Apellidos">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nombre de Usuario">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="text" name="email" id="email" class="form-control" placeholder="Correo Electrónico">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="text" name="dui" id="dui" class="form-control" placeholder="Dui">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<select id="departamento" class="form-control" name="departamento" required="">
	  										<option selected="true" hidden="true" value="" disabled>-- Departamento --</option>
	  										<?php 
	  										foreach ($zonas as $zona) {
	  											echo "<option value='".$zona['zona']."'>".$zona['zona']."</option>";
	  										}
	  										?>
	  									</select>
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirmar contraseña">
	  								</div>
	  							</div>
	  							<div class="form-group">
	    							<div class="col-sm-9">
	    								<input type="hidden" name="frm_reg_ven_sent">
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
	</div>	<!--/.main-->
	
 </div>
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

		$("#select_categorias_u").change(function() {
			var value = $(this).val();
			if (value == 0) {
				document.location.href = document.location.origin + "/progra/ad_usuarios.php?users=clientes";
			} else if (value == 1) {
				document.location.href = document.location.origin + "/progra/ad_usuarios.php?users=vendedores";
			} else if (value == 2) {
				document.location.href = document.location.origin + "/progra/ad_usuarios.php?users=gerencia";
			} else {
				document.location.href = document.location.origin + "/progra/ad_usuarios.php";
			}
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

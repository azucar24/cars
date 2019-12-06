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

if (isset($_POST['pulsado_save'])) {
	$id_auto = $_POST['id'];
	$id_usuario = $_POST['id_usuario'];
	$monto = $_POST['monto'];
	$id_vendedor;

	//para obtener el id del vendedor
	$model = new Crud;
	$model->select = "*";
	$model->from = "usuarios";
	$model->condition = " WHERE username='$usuario'";
	$model->Read();
	$filas2 = $model->rows;
	$id_vendedor = $filas2[0]['id_usuario'];
	$departamento = $filas2[0]['departamento'];


	$model = new Crud();
	$model->insertInto = 'ventas';
	$model->insertColumns = 'id_usuario, id_auto, id_vendedor';
	$model->insertValues = "$id_usuario, $id_auto, $id_vendedor";
	$model->Create();

	$model = new Crud();
	$model->insertInto = 'ventas2';
	$model->insertColumns = 'usuario, monto, departamento';
	$model->insertValues = "'$usuario', '$monto', '$departamento'";
	$model->Create();


	$mensaje = "<script>";
	$mensaje .= "alert('La venta ha sido realizada.');";
	$mensaje .= "document.location.href = document.location.href;";
	$mensaje .= "</script>";
	echo $mensaje;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AM-VENDEDOR</title>

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
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>AM</span>VENDEDOR</a>
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
			<li class="active"><a href="vendedor.php"><span class="icon-automobile icono"></span> Vender Autos</a></li>
			<li><a href="vend_ventas.php"><span class="icon-money"></span> Autos Vendidos</a></li>
			<li role="presentation" class="divider"></li>
		</ul>

	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Vender Auto</h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-8 col-sm-offset-1">
				<form class="form-horizontal">
  					<div class="form-group">
    					<label for="inputPassword" class="col-sm-4 control-label">Nombre de Usuario del Cliente</label>
    					<div class="col-sm-6">
      						<input type="text" class="form-control" id="nombre">
    					</div>
  					</div>
				</form>
			</div>
		</div>
				
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1 autos_del_vendedor">
			</div>
		</div><!--/.row-->

	</div>	<!--/.main-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		$('#calendar').datepicker({
		});

		$("#nombre").keyup(function() {
			var username = $.trim($(this).val());
			var urli = window.window.location.href;

			if (username != "") {
				$.ajax({
					url:'php/includes/buscar_cliente.php',
					data:{
						username:username,
						url: urli
					},
					type: 'POST',
					success:function(data){
						if(!data.error){
							$(".autos_del_vendedor").html(data);
						}
					}
				});
			}
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
	</script>	
</body>

</html>

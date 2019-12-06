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
$model->select = " departamento, SUM(monto) AS monto_total, COUNT(*) AS total";
$model->from = "ventas2";
$model->condition = " GROUP BY departamento";
$model->Read();
$filas_g_a = $model->rows;
$total = count($filas_g_a);

$model = new Crud;
$model->select = " usuario, SUM(monto) AS monto_total, COUNT(*) AS total";
$model->from = "ventas2";
$model->condition = " GROUP BY usuario";
$model->Read();
$filas_u_a = $model->rows;


$model = new Crud;
$model->select = " nombre, COUNT(*) AS total ";
$model->from = "autos";
$model->condition = " WHERE id_auto IN ( SELECT id_auto FROM autos_guardados ) GROUP BY nombre";
$model->Read();
$filas_a_a = $model->rows;

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
			<li class="active">
			<a href="admin.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Tablero</a></li>
			<li><a href="ad_autos_venta.php"><span class="icon-automobile icono"></span>Autos en venta</a></li>
			<li><a href="ad_usuarios.php"><span class="icon-users icono"></span>Usuarios</a></li>
			<li><a href="ad_puntos_centas.php"><span class="icon-location icono"></span>Puntos de venta</a></li>
			<li role="presentation" class="divider"></li>
		</ul>

	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Tablero</h1>
			</div>
		</div><!--/.row-->
		
		<?php require_once("php/includes/encabezado_admin.php");?>
		<style type="text/css">
			#chart_wrap, #chart_wrap2, #chart_wrap3 {
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
		</style>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Ventas por departamentos</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6 col-xs-10 col-md-offset-1 col-xs-offset-1">
								<div id="chart_wrap"><div id="chart"></div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Ventas por Vendedores</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6 col-xs-10 col-md-offset-1 col-xs-offset-1">
								<div id="chart_wrap2"><div id="chart2"></div></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Autos Vendidos</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6 col-xs-10 col-md-offset-1 col-xs-offset-1">
								<div id="chart_wrap3"><div id="chart3"></div></div>
							</div>
						</div>
					</div>
				</div>
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

		// Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      $(window).on("throttledresize", function (event) {
      	 drawChart2();
    	drawChart();
    	drawChart3();
    });

      $(window).resize(function() {
        drawChart();
        drawChart2();
        drawChart3();
      });

      setTimeout(function(){
      	drawChart();
      	drawChart2();
      	drawChart3();
      },1000);
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        	<?php 
        	foreach ($filas_g_a as $fila) {
        		echo "['".$fila['departamento']. ' ('.$fila['total']." venta/s)', ". $fila['monto_total'].'],';
        	}
        	?>
        	]);

        

        // Set chart options
        var options = {
            chartArea: {
                left: "3%",
                top: "3%",
                height: "94%",
                width: "94%"
            },
            width: '100%',
            height: '100%',
            pieSliceText: 'percentage',
            colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
        };

        // Instantiate and draw our chart, passing in some options.

        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        chart.draw(data, options);
      }


// Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart2);
function drawChart2() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        	<?php 
        	foreach ($filas_u_a as $fila) {
        		echo "['".$fila['usuario']. ' ('.$fila['total']." venta/s)', ". $fila['monto_total'].'],';
        	}
        	?>
        	]);

        

        // Set chart options
        var options = {
            chartArea: {
                left: "3%",
                top: "3%",
                height: "94%",
                width: "94%"
            },
            width: '100%',
            height: '100%',
            pieSliceText: 'percentage'
        };

        // Instantiate and draw our chart, passing in some options.

        var chart = new google.visualization.PieChart(document.getElementById('chart2'));
        chart.draw(data, options);
      }

      function drawChart3() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
        	<?php 
        	foreach ($filas_a_a as $fila) {
        		echo "['".$fila['nombre']. ' ('.$fila['total'].")', ". $fila['total'].'],';
        	}
        	?>
        	]);

        

        // Set chart options
        var options = {
            chartArea: {
                left: "3%",
                top: "3%",
                height: "94%",
                width: "94%"
            },
            width: '100%',
            height: '100%',
            pieSliceText: 'percentage',
            colors: ['#f3b49f', '#f6c7b6']
        };

        // Instantiate and draw our chart, passing in some options.

        var chart = new google.visualization.PieChart(document.getElementById('chart3'));
        chart.draw(data, options);
      }

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

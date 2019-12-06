<?php 

require_once('conexion.php');
require_once('crud.php');

$model = new Crud;
$model->select = " *";
$model->from = "usuarios";
$model->condition = " WHERE privilegios='0'";
$model->Read();
$filas_g = $model->rows;
$total1 = count($filas_g);

$model = new Crud;
$model->select = " departamento, SUM(monto) AS monto_total, COUNT(*) AS total";
$model->from = "ventas2";
$model->Read();
$filas_g = $model->rows;
$total = count($filas_g);
$total_ventas = $filas_g[0]['monto_total'];


$model = new Crud;
$model->select = " *";
$model->from = "usuarios";
$model->condition = " WHERE privilegios='1'";
$model->Read();
$filas_g = $model->rows;
$total_ve = count($filas_g);
?>

<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $total1;?></div>
							<div class="text-muted">Clientes</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<span class="icon-money" style="font-size: 50px;"></span>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">$<?php echo $total_ventas;?></div>
							<div class="text-muted">En ventas</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<span class="icon-shop" style="font-size: 50px;"></span>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $total_ve?></div>
							<div class="text-muted">Vendedores
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
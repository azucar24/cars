<?php 

$cliente = $_POST['username'];
$url = $_POST['url'];

require_once('conexion.php');
require_once('crud.php');

$model = new Crud;
$model->select = "*";
$model->from = "usuarios";
$model->condition = " WHERE username='$cliente'";
$model->Read();
$filas = $model->rows;
$total = count($filas);

$id_usuario = $filas[0]['id_usuario'];
$salida = "";
if ($total > 0) {
	if ($filas[0]['privilegios'] == 1) {
		$salida .= '<div class="alert alert-danger">';
  		$salida .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'; 
  		$salida .= '<strong>Ooops!</strong> Error, no deberia ingresar su nombre de usuario.
				</div>';
		echo $salida;
		return;
	} else {
		$model = new Crud;
		$model->select = "*";
		$model->from = "usuarios";
		$model->condition = " WHERE username='$cliente'";
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

		if (count($filas) > 0) {	
			$salida = "<h2>Autos que el cleinte ha guardado.</h2>";
		$contador = 0;
		$salida .= '<div class="row">';
			foreach ($filas as $fila) {
				if ($fila['stock'] > 0) {
					if ($contador % 3 == 0) {
						$salida .= "<div class='row' style='margin-top:20px;'>";
					}
					
					$salida .= '<div class="col-md-4 col-sm-4" style="margin-top: 20px;">';
					$salida .= '<div class="targeta">';
					$salida .= '<img src="'.$fila['img'].'" width="100%" height="100%">';
					$salida .= '<div class="regilla">';
					$salida .= '<div><b>Marca: </b>"'. $fila['marca'] . "</div>";
					$salida .= '<div><b>Modelo: </b>"'. $fila['modelo'] . '</div>';
					$salida .= '<div>'.'<b>Precio: </b> $"'.$fila['precio'].'</div>';
					$salida .= '<div><b>Cantidad Disp.</b>'.$fila['stock'].'</div>';
					$salida .= '</div>';
					$salida .=  "<div class='btn_agragar_fav'>";
					$salida .= '<form method="post" id="form_save" action="'.$url.'">';
					$salida .= '<input type="hidden" name="id" value="'.$fila['id_auto'].'">';
					$salida .= '<input type="hidden" name="id_usuario" value="'.$id_usuario.'">';
					$salida .= '<input type="hidden" name="monto" value="'.$fila['precio'].'">';
					$salida .= '<input type="hidden" name="pulsado_save" value="pulsado_save">';
					$salida .= '<button type="submit" class="btn btn-info"><span class="icon-money" style="font-size:30px;"></span></span></button>';
					$salida .= '</form>';
					$salida .= '</div>';
					$salida .= '</div>';
					$salida .= '</div>';
						$contador++;
						if ($contador % 3 == 0) {
							$salida .= "</div>";
						}
						}
					}
			$salida .= '</div>';
		$salida .= '</div>';
		echo $salida;
	} else {
		$salida .= '<div class="alert alert-danger">';
  		$salida .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'; 
  		$salida .= '<strong>Ooops!</strong> El usuario no ha guardado ningun auto, para realizar la compra pidele que ingrese con sus credenciales y guarde el auto que desea comprar.</div>';
		echo $salida;
	}

		return;
	}
} else {
	$salida .= '<div class="alert alert-danger">';
  		$salida .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'; 
  		$salida .= '<strong>Ooops!</strong> Error, El usuario no existe en nuestra base de datos, pidele que se registre.
				</div>';
		echo $salida;
	return;
}
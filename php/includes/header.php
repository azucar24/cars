<nav id="menu_navegacion">
	<div class="container-fluid">
		<div class="header align-left">
			<a href="#" style="float: left"><img src="images/loo.png" width="80" height="60" id="img_logo"></a>
			<span style="float: left; line-height: 60px; color: #fff; font-size: 20px; font-weight: bold">Venta de Autos</span>
		</div>
		<div class="align-right">
			<span id="mostrar_menu" class="icon-bars"></span>
			<ul class="navigation">
				<li><a href="index.php" class="menu-option <?php if($section == 'index'){ echo 'active';}?>"><span class="icon-home icono"></span>Inicio</a></li>
				<?php if (!isset($_SESSION['u_usuario'])) {?>
				<li><a href="login.php" class="menu-option <?php if($section == 'login'){ echo 'active';}?>"><span class="icon-login icono"></span>Iniciar Sesion</a></li>
				<li><a href="register.php" class="menu-option <?php if($section == 'register'){ echo 'active';}?>"><span class="icon-user-plus icono"></span>Registrarme</a></li>
				<?php  } else { ?>
                <li><a href="catalogo.php" class="menu-option <?php if($section == 'catalogo'){ echo 'active';}?>"><span class="icon-shop icono"></span>Catálago de ventas</a></li>
				<li><a href="userok.php" class="menu-option <?php if($section == 'saved'){ echo 'active';}?>"><span class="icon-save icono"></span>Autos Guardados</a></li>
				<li><a href="php/includes/cerrar_session.php" class="menu-option"><span class="icon-log-out"></span></span>Cerrar Sesion</a></li>
				<?php }?>
			</ul>
		</div>
	</div>
</nav>

<?php
if(!isset($justCloseWindow)) $justCloseWindow=false
?>
<div class="barra_navegacion">
	<div class="container">
		<img src="<?= base_url('project_files/img/sistema/logo_simma.png'); ?>" class="logo_simma" onclick="location.href='<?= base_url('inicio/principal'); ?>'" />
		<div class="btn-group pull-right menu_principal">
			<?php if(!$justCloseWindow)
			{
				?>
				<?php if($this->modsesion->hasPermisoHijo(1)): ?>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Administración">
						Administración <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php if($this->modsesion->hasPermisoHijo(5)): ?>
						<li><a href="<?= base_url('clientes'); ?>">Clientes</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(6)):?>
						<li><a href="<?= base_url('empresas'); ?>">Empresas</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(7)):?>
						<li><a href="<?= base_url('sucursales'); ?>">Sucursales</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(8)):?>
						<li><a href="<?= base_url('operadores'); ?>">Operadores</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(9)):?>
						<li><a href="<?= base_url('vehiculos'); ?>">Vehiculos</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(52)):?>
						<li><a href="<?= base_url('rutas'); ?>">Rutas</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(53)):?>
						<li><a href="<?= base_url('residuos'); ?>">Residuos</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<?php endif;
				if($this->modsesion->hasPermisoHijo(2)): ?>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Administración">
						Operación <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php if($this->modsesion->hasPermisoHijo(18)): ?>
						<li><a href="<?= base_url('manifiestos'); ?>">Manifiestos</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(19)):?>
						<li><a href="<?= base_url('bitacoras'); ?>">Bitácoras</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<?php endif;
				if($this->modsesion->hasPermisoHijo(3)):?>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Configuración">
						Configuracion <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php if($this->modsesion->hasPermisoHijo(82)): ?>
						<li><a href="<?= base_url('cambiopassword'); ?>">Cambiar Contraseña</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(81)):?>
						<li><a href="<?= base_url('reseteopassword'); ?>">Resetear Contraseña</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(29)):?>
						<li><a href="<?= base_url('catalogos'); ?>">Catalogos</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(109)):?>
						<li><a href="<?= base_url('grupos'); ?>">Grupos de Clientes</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(26)):?>
						<li><a href="<?= base_url('usuarios'); ?>">Usuarios</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(28)):?>
						<li><a href="<?= base_url('perfiles'); ?>">Perfiles</a></li>
						<?php endif;
						if($this->modsesion->hasPermisoHijo(27)):?>
						<li><a href="<?= base_url('permisos'); ?>">Permisos</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<?php endif; ?>
				<button type="button" class="btn btn-default" title="Ayuda" onclick="window.open('<?= base_url('ayuda'); ?>','help_window')">
					<span class="glyphicon glyphicon-question-sign"></span>
				</button>
				<button type="button" class="btn btn-default" title="Salir" onclick="location.href=baseURL+'sesiones/logout'">
					<span class="glyphicon glyphicon-off"></span>
				</button>
				<?php
			}
			else
			{
				?>
				<button type="button" class="btn btn-default" title="Cerrar Ventana" onclick="window.close()">
					<span class="glyphicon glyphicon-remove-circle"></span>
				</button>
				<?php
			}
			?>
		</div>
	</div>
</div>
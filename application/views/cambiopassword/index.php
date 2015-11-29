<?= $menumain; ?>
<div class="container">
	<h3>Cambiar Contraseña</h3>
	<form class="form-horizontal" role="form" id="frm_data">
		<div class="form-group">
			<label class="col-sm-5 control-label" for="frm_data_actual">Contraseña Actual:</label>
			<div class="col-sm-7">
        		<input type="password" class="form-control" id="frm_data_actual" name="frm_data_actual" maxlength="250" />
        	</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label" for="frm_data_nueva">Contraseña Nueva:</label>
			<div class="col-sm-7">
        		<input type="password" class="form-control" id="frm_data_nueva" name="frm_data_nueva" maxlength="250" />
        	</div>
		</div>
		<div class="form-group">
			<label class="col-sm-5 control-label" for="frm_data_confirmacion">Confirmar Contraseña Nueva:</label>
			<div class="col-sm-7">
        		<input type="password" class="form-control" id="frm_data_confirmacion" name="frm_data_confirmacion" maxlength="250" />
        	</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9"></div>
			<div class="col-sm-3">
			    <button type="button" class="btn btn-success" onclick="Usuario.CambiarPwd()" >Cambiar Contraseña</button>
			</div>
		</div>
	</form>
</div>
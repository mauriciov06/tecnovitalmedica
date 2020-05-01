<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			{!!Form::label('Insitucion al que pertenece:')!!}
			{!!Form::select('id_instituciones',$instituciones, null,['placeholder'=>'Seleccionar Insitución','id'=>'select_insti','class'=>'form-control'])!!}
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			{!!Form::label('Tipo de Archivo:')!!}
			{!!Form::select('tipo_archivo',['' => 'Elegir', '1' => 'Hoja de Vida', '2' => 'Mantenimientos', '3' => 'Calibraciones', '4' => 'Guias', '5' => 'Manuales', '6' => 'Procesos de Mantenimiento', '7' => 'Otros'],null,['id'=>'selec_tipo_archivo','class'=>'form-control'])!!}
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="equipo-none">
		<div class="form-group">
			{!!Form::label('Equipo al cual pertenece:')!!}
			{!!Form::select('id_equipo_medico',[''=>'Seleccionar equipo'], null,['id'=>'select_equipo','class'=>'form-control'])!!}
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			{!!Form::label('Nombre del archivo:')!!}
			{!!Form::text('nombre_archivo',null,['class'=>'form-control'])!!}
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-8 adjuntar_file">
		<div class="form-group">
			<input type="file" name="url_archivo" id="files" class="inputfile inputfile-1" />
			<label for="url_archivo"><span>Adjuntar Archivo</span></label>
		</div>
	</div>	
</div>
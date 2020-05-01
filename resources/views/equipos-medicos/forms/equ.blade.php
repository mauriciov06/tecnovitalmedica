<div class="row">	
	<div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
		<div class="form-group">
			<output id="list">
			<?php if(!empty($equipo)){ ?>
				<img class="thumb" src="/avatares/{!!$equipo->url_imagen_equipo!!}" alt="">
			<?php } ?>
			</output>
			<input type="file" name="url_imagen_equipo" id="files" class="inputfile inputfile-1" />
			<label for="url_imagen_equipo"><span>Seleccionar avatar</span></label>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Institución a la que pertenece:')!!}
		{!!Form::select('id_instituciones',$instituciones, null,['class'=>'form-control'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Modelo:')!!}
		{!!Form::text('modelo',null,['class'=>'form-control'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			{!!Form::label('Nombre del equipo:')!!}
			{!!Form::text('nombre_equipo_medico',null,['class'=>'form-control'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('Serie:')!!}
			{!!Form::text('serie',null,['class'=>'form-control'])!!}
		</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Marca:')!!}
		{!!Form::text('marca',null,['class'=>'form-control'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Activo Fijo:')!!}
		{!!Form::text('activo_fijo',null,['class'=>'form-control'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Ubicación:')!!}
		{!!Form::text('ubicacion',null,['class'=>'form-control'])!!}
	</div>
</div>
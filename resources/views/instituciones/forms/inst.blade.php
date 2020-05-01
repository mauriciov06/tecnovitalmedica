<div class="row">	
	<div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
		<div class="form-group">
			<output id="list">
			<?php if(!empty($institucion)){ ?>
				<img class="thumb" src="/avatares/{!!$institucion->avatar_instituciones!!}" alt="">
			<?php } ?>
			</output>
			<input type="file" name="avatar_instituciones" id="files" class="inputfile inputfile-1" />
			<label for="avatar_instituciones"><span>Seleccionar avatar</span></label>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			{!!Form::label('Nombre completo:')!!}
			{!!Form::text('nombre_instituciones',null,['class'=>'form-control'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('Telefono:')!!}
			{!!Form::text('telefono_instituciones',null,['class'=>'form-control'])!!}
		</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Correo Electronico:')!!}
		{!!Form::email('email_instituciones',null,['class'=>'form-control'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Ciudad:')!!}
		{!!Form::select('id_ciudad',$ciudad, null,['class'=>'form-control'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Celular:')!!}
		{!!Form::text('celular_instituciones',null,['class'=>'form-control'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Dirección:')!!}
		{!!Form::text('direccion_instituciones',null,['class'=>'form-control'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Nombre de la carpeta:')!!}
		{!!Form::text('nombre_carpeta_institucion',null,['class'=>'form-control', 'id'=>'nombre_carpeta_inst'])!!}
		<small>El nombre de la carpeta no se podra cambiar una vez ingresado.</small>
	</div>
</div>

@section('scripts')
<script>
$( document ).ready(function() {
    if($('#nombre_carpeta_inst').val() != ''){
        $('#nombre_carpeta_inst').attr('disabled', true);   
    }
});
</script>

@endsection









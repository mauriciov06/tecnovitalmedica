<div class="row">	
	<div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
		<div class="form-group">
			<output id="list">
			<?php if(!empty($user)){ ?>
				<img class="thumb" src="/avatares/{!!$user->avatar!!}" alt="">
			<?php } ?>
			</output>
			<input type="file" name="avatar" id="files" class="inputfile inputfile-1" />
			<label for="avatar"><span>Seleccionar avatar</span></label>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Nombre:')!!}
		{!!Form::text('name',null,['class'=>'form-control', 'id'=>'nombre_usr'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Telefono:')!!}
		{!!Form::text('telefono',null,['class'=>'form-control'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Correo Electronico:')!!}
		{!!Form::email('email',null,['class'=>'form-control', 'id'=>'correo_usr'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Ciudad:')!!}
		{!!Form::select('id_ciudad',$ciudad, null,['class'=>'form-control', 'id'=>'ciudad_usr'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Celular:')!!}
		{!!Form::text('celular',null,['class'=>'form-control'])!!}
	</div>
	<div class="form-group">
		{!!Form::label('Contraseña:')!!}
		{!!Form::password('password',['class'=>'form-control'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Tipo de cuenta:')!!}
		{!!Form::select('tipo_cuenta',$tipoCuentas, null,['class'=>'form-control', 'id'=>'tipo_cuenta', 'placeholder' => 'Seleccione una cuenta'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 select_institucion">
	<div class="form-group">
		{!!Form::label('Institución:')!!}
		{!!Form::select('id_institucion',$instituciones, null,['class'=>'form-control', 'id'=>'id__user_institucion', 'placeholder' => 'Seleccione una institución'])!!}
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3 style="font-family: 'Lato', sans-serif;border-top: 1px solid #ccc;padding-top: 25px;font-size: 30px;">Permisos</h3>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
    	{!!Form::label('Seleccione los permisos:')!!}
    	<div class="form-group">
            <input value="<?php if(!empty($permisosUsers)) echo $permisosUsers->ids_permisos; ?>" name="permisos" id="permisos" class="form-control" />
        </div>
    </div>
</div>


@section('scripts')
<?php if(Auth::user()->tipo_cuenta != 1 && !empty($user)){ ?>
    <script>
    	jQuery(document).ready(function() {
    		jQuery('#nombre_usr').attr('disabled',true);
    		jQuery('#correo_usr').attr('disabled',true);
    		jQuery('#ciudad_usr').attr('disabled',true);
    		jQuery('#tipo_cuenta').attr("disabled", true);
    		jQuery('#id__user_institucion').attr("disabled", true);
    	});
    </script>
<?php } ?>
@show



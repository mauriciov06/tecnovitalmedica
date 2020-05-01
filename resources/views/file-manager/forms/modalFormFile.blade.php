<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="form-group">
      {!!Form::label('Nombre del archivo:')!!}
      {!!Form::text('nombre_archivo',null,['class'=>'form-control', 'id'=>'nombre_archivo'])!!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="form-group">
      {!!Form::label('Fecha de realización:')!!}
      {!!Form::date('fecha_realizacion', \Carbon\Carbon::now()->subDay(), ['class' => 'form-control','id'=>'fecha_realizacion'])!!}
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="form-group">
        <input type="file" name="archivo_file_manager" id="files" class="inputfile inputfile-1" />
		<label for="archivo_file_manager"><span>Seleccionar archivo</span></label>
    </div>
</div>
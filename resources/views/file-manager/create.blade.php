@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4>Subir Archivo</h4>
		</div>
		<div id="conten-form" class="form-manager-file">	
			{!!Form::open(['route'=>'filemanager.store', 'method'=>'POST', 'files'=>true])!!}
				<div class="row">
					@include('file-manager.forms.flm')
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!!Form::submit('Guardar Cambios',['class'=>'btn btn-accion'])!!}
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
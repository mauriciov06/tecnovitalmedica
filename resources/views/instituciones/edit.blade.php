@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Editar Instituciones</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
			    <a href="/instituciones" class="btn-listar">Listar institución</a>
			@endif
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			    <a href="/instituciones/create" style="margin-right: 10px;" class="btn-listar">Crear institución</a>
			@endif
		</div>
		<div id="conten-form">
			{!!Form::model($institucion, ['route'=> ['instituciones.update', $institucion->id], 'method'=>'PUT', 'files'=>true])!!}	
				<div class="row">
					@include('instituciones.forms.inst')
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!!Form::submit('Editar Institución',['class'=>'btn btn-accion'])!!}
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
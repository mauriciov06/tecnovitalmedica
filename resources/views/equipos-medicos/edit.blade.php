@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Editar Equipo Medico</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
			<a href="/equipos" class="btn-listar">Listar equipos</a>
			@endif
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			<a href="/equipos/create" class="btn-listar" style="margin-right: 10px;">Crear equipo</a>
			@endif
		</div>
		<div id="conten-form">	
			{!!Form::model($equipo, ['route'=> ['equipos.update', $equipo->id], 'method'=>'PUT', 'files'=>true])!!}	
				<div class="row">
					@include('equipos-medicos.forms.equ')
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!!Form::submit('Editar Equipo Medico',['class'=>'btn btn-accion'])!!}
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Datos del Equipo</h4>
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
					@include('equipos-medicos.forms.equshow')
				</div>
			{!!Form::close()!!}
			<div class="row text-center">
				<a href="{!!URL::to('/equipos')!!}" class="btn btn-volver-lista">Volver a la lista</a>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
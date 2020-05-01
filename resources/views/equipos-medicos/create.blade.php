@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Agregar Equipo Medico</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
			    <a href="/equipos" class="btn-listar">Listar equipos</a>
			@endif
		</div>
		<div id="conten-form">	
			{!!Form::open(['route'=>'equipos.store', 'method'=>'POST', 'files'=>true])!!}
				<div class="row">
					@include('equipos-medicos.forms.equ')
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!!Form::submit('Agregar Equipo Medico',['class'=>'btn btn-accion'])!!}
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
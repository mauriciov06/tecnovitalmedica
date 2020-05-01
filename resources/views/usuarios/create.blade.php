@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Agregar Usuario</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
			    <a href="/usuarios" class="btn-listar">Listar usuarios</a>
			@endif
		</div>
		<div id="conten-form">	
			{!!Form::open(['route'=>'usuarios.store', 'method'=>'POST', 'files'=>true])!!}
				<div class="row">
					@include('usuarios.forms.usr')
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						{!!Form::submit('Agregar Usuario',['class'=>'btn btn-accion'])!!}
					</div>
				</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
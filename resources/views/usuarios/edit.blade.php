@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Editar Usuario</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
			    <a href="/usuarios" class="btn-listar">Listar usuarios</a>
			@endif
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			    <a href="/usuarios/create" style="margin-right: 10px;" class="btn-listar">Crear usuario</a>
			@endif
		</div>
		<div id="conten-form" class="<?php if(!empty($user)) echo 'edit-users-class'; ?>">
			{!!Form::model($user, ['route'=> ['usuarios.update', $user->id], 'method'=>'PUT', 'files'=>true])!!}
			<div class="row">
				@include('usuarios.forms.usr')
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					{!!Form::submit('Actualizar',['class'=>'btn btn-accion'])!!}
				</div>
			</div>
			{!!Form::close()!!}
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection
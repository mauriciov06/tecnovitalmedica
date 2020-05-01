@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Listado de Usuarios</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			<a href="/usuarios/create" class="btn-listar" style="margin-right: 10px;">Crear usuario</a>
			@endif
		</div>

		{!!Form::model(Request::all(), ['route'=>'usuarios.index', 'method'=>'GET', 'role'=>'search'])!!}
		  <div class="input-group search_filter">
		    @include('search.search_usuario')
		    <span class="input-group-btn">
	        {!!Form::submit('Buscar',['class'=>'btn btn-search'])!!}
	      </span>
		  </div>
		{!!Form::close()!!}
		
		<div class="users">
		    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    			@if(count($users) > 0)
    				<table class="table table-sty">
    					<thead>
    						<th>Nombre Completo</th>
    						<th>Tipo de cuenta</th>
    						<th>Correo Electronico</th>
    						<th>Institución</th>
    						<th>Ciudad</th>
    						<th>Acciones</th>
    					</thead>
    					@foreach($users as $user)
    					<tbody>
    						<td class="first-item-table">
    							{{$user->name}}
    						</td>
    						<td>{!! Tecnovitalmedica\Http\Controllers\UsuarioController::getUserTipoCuenta($user->tipo_cuenta) !!}</td>
    						<td>{{$user->email}}</td>
    						<td>
    						{{ Tecnovitalmedica\Http\Controllers\UsuarioController::getUserInstitucion($user->id_institucion) }}
    						</td>
    						<td>
    						<?php 
    							$ciudads = json_decode($ciudades, true);
    							foreach ($ciudads as $id_ciudad => $nombreCiudad) {
    								if($id_ciudad == $user->id_ciudad){
    									echo $nombreCiudad;
    								}
    							}
    						?>
    						</td>
    						<td>
    						    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 2))
    							<a title="Editar" class="btn btn-primary" href="/usuarios/{!! $user->id !!}/edit"><i class="fas fa-edit"></i></a>
    							@endif
    							@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
    							    <div style="display: inline-block;">
    								    <a title="Eliminar" class="btn btn-danger btn-eliminar" data-toggle="modal" data-name="{{$user->name}}" data-id="{{$user->id}}" data-tipo="usuario" data-target="#modalEliminar"><i class="fas fa-trash-alt"></i></a>
    							    </div>
    							@endif
    							
    						</td>
    					</tbody>
    					@endforeach
    				</table>
    				{!! $users->appends(request()->input())->render() !!}
    			@else
    				<hr>
    				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> 
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Upps!</strong> No se encontraron resultados. <a href="/usuarios/create">Crear usuario</a>
    				</div>
    			@endif
    		@else
				<hr>
				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> 
					<strong>Upps!</strong> No tienes permisos para ver los listados.
				</div>
			@endif
		</div>
	</div>
@stop
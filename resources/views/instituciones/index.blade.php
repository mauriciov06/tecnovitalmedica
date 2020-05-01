@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Listado de Instituciones</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			    <a href="/instituciones/create" class="btn-listar">Crear institución</a>
			@endif
		</div>
		
		@if(Auth::user()->tipo_cuenta == 1)
			{!!Form::model(Request::all(), ['route'=>'instituciones.index', 'method'=>'GET', 'role'=>'search'])!!}
			  <div class="input-group search_filter">
			    @include('search.search_institucion')
			    <span class="input-group-btn">
		        {!!Form::submit('Buscar',['class'=>'btn btn-search'])!!}
		      </span>
			  </div>
			{!!Form::close()!!}
		@endif

		<div class="users">
		    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    			@if(count($instituciones) > 0)
    				<table class="table table-sty" style="margin-top: 15px;">
    					<thead>
    						<th>Nombre Institución</th>
    						<th>Correo Electronico</th>
    						<th>Ciudad</th>
    						<th>Acciones</th>
    					</thead>
    					@foreach($instituciones as $institucion)
    					<tbody>
    						<td class="first-item-table">
    							{{$institucion->nombre_instituciones}}
    						</td>
    						<td>{{$institucion->email_instituciones}}</td>
    						<td>
    						<?php 
    							$ciudads = json_decode($ciudades, true);
    							foreach ($ciudads as $id_ciudad => $nombreCiudad) {
    								if($id_ciudad == $institucion->id_ciudad){
    									echo $nombreCiudad;
    								}
    							}
    						?>
    						</td>
    						<td>
    							@if(Auth::user()->tipo_cuenta == 1)
    								@if($institucion->id_contacto_usuario == 0)
    									@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
        										<a title="Crear contacto" href="#" data-idinstitucion="<?php echo $institucion->id; ?>" class="btn btn-success crear_contacto" data-toggle="modal" data-target="#modalContacto"><i class="fas fa-user-plus"></i></a>
    									@endif
    								@else
    									
        								@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
        										<a title="Ver contacto" href="#" data-idusucontacto="<?php echo $institucion->id_contacto_usuario; ?>" class="btn btn-success ver_contacto" data-toggle="modal" data-target="#modalActualizarContacto"><i class="fas fa-user-check"></i></a>
        								@endif
    								@endif
    								
    								@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    								<a title="Listado de procesos" class="btn btn-warning" href="/instituciones/procesos/{{$institucion->id}}"><i class="fas fa-file-alt"></i></a>
    								@endif
    								
    								@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 2))
    								<a title="Editar" class="btn btn-primary" href="/instituciones/{!! $institucion->id !!}/edit"><i class="fas fa-edit"></i></a>
    								@endif
    								@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
    								<div style="display: inline-block;">
    									<a title="Eliminar" class="btn btn-danger btn-eliminar" data-toggle="modal" data-name="{{$institucion->nombre_instituciones}}" data-id="{{$institucion->id}}" data-tipo="institucion" data-target="#modalEliminar"><i class="fas fa-trash-alt"></i></a>
    								</div>
    								@endif
    							@else
    							    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    								<a title="Listado de procesos" class="btn btn-warning" href="/instituciones/procesos/{{$institucion->id}}"><i class="fas fa-file-alt"></i></a>
    								@endif
    							@endif
    						</td>
    					</tbody>
    					@endforeach
    				</table>
    				{!!$instituciones->appends(request()->input())->render()!!}
    			@else
    				<hr>
    				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> 
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Upps!</strong> No se encontraron resultados. @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1)) <a href="/instituciones/create">Crear institución</a> @endif
    				</div>
    			@endif
    		@else
    			<hr>
    			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> <strong>Upps!</strong> No tienes permisos para ver los listados. @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1)) <a href="/instituciones/create">Crear institución</a> @endif
    			</div>
    		@endif
		</div>
	</div>
@stop
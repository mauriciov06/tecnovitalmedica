@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Listado de Equipos Medicos</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			    <a href="/equipos/create" class="btn-listar" style="margin-right: 10px;">Crear equipo</a>
			@endif
		</div>

		{!!Form::model(Request::all(), ['route'=>'equipos.index', 'method'=>'GET', 'role'=>'search'])!!}
		  <div class="input-group search_filter_equipos search_filter <?php if(Auth::user()->tipo_cuenta != 1) echo 'select-insti-none'; ?>">
		    @include('search.search_equipos')
		    <span class="input-group-btn">
	        {!!Form::submit('Buscar',['class'=>'btn btn-search'])!!}
	      </span>
		  </div>
		{!!Form::close()!!}

		<div class="users">
		    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    			@if(count($equipos) > 0)
    				<table class="table table-sty">
    					<thead>
    						<th>Nombre del equipo</th>
    						<th>Marca</th>
    						<th>Modelo</th>
    						<th>Ubicación</th>
    						<th>Institución</th>
    						<th>Acciones</th>
    					</thead>
    					@foreach($equipos as $equipo)
    					<tbody>
    						<td class="first-item-table">
    							{{$equipo->nombre_equipo_medico}}
    						</td>
    						<td>{{$equipo->marca}}</td>
    						<td>{{$equipo->modelo}}</td>
    						<td>{{$equipo->ubicacion}}</td>
    						<td>{{ Tecnovitalmedica\Http\Controllers\UsuarioController::getUserInstitucion($equipo->id_instituciones) }}</td>
    						<td>
						        @if (Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
    							    <a title="Ver equipo" href="/equipos/{{$equipo->id}}" class="btn btn-success"><i class="far fa-eye"></i></a>
    							@endif
    							@if(Auth::user()->tipo_cuenta == 1)
    							    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 2))
    								    <a title="Editar" class="btn btn-primary" href="/equipos/{!! $equipo->id !!}/edit"><i class="fas fa-edit"></i></a>
    								@endif
    								
    								@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
        								<div style="display: inline-block;">
        									<a title="Eliminar" class="btn btn-danger btn-eliminar" data-toggle="modal" data-name="{{$equipo->nombre_equipo_medico}}" data-id="{{$equipo->id}}" data-tipo="equipo" data-target="#modalEliminar"><i class="fas fa-trash-alt"></i></a>
        								</div>
    								@endif
    							@endif
    						</td>
    					</tbody>
    					@endforeach
    				</table>
    				{!!$equipos->appends(request()->input())->render()!!}
    			@else
    				<hr>
    				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> 
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Upps!</strong> No se encontraron resultados. @if(Auth::user()->tipo_cuenta == 1)<a href="/equipos/create">Crear equipo medico</a> @endif
    				</div>
    			@endif
    	    @else
				<hr>
				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> 
					<strong>Upps!</strong> No tienes permisos para ver los listados. @if(Auth::user()->tipo_cuenta == 1) @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1)) <a href="/equipos/create">Crear equipo medico</a> @endif @endif
				</div>
			@endif
		</div>
	</div>
@stop
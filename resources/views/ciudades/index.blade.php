@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4 class="pull-left">Listado de Ciduades</h4>
			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
			    <a class="btn crear-ciudad" data-toggle="modal" data-target="#modalCrearCiudad">Crear ciudad</a>
			@endif
		</div>

		<div class="users">
		    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    			@if(count($ciudades) > 0)
    				<table class="table table-sty" style="margin-top: 15px;">
    					<thead>
    						<th>Nombre Ciudad</th>
    						<th>Acciones</th>
    					</thead>
    					@foreach($ciudades as $ciudad)
    					<tbody>
    						<td class="first-item-table">
    							{{$ciudad->nombre_ciudad}}
    						</td>
    						<td>
    						    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 2))
    							<a title="Editar" class="btn btn-primary" data-toggle="modal" data-target="#modalEditarCiudad" data-id="{{$ciudad->id}}"><i class="fas fa-edit"></i></a>
    							@endif
    							@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
    							<div style="display: inline-block;">
    								<a title="Eliminar" class="btn btn-danger btn-eliminar" data-toggle="modal" data-name="{{$ciudad->nombre_ciudad}}" data-id="{{$ciudad->id}}" data-tipo="ciudad" data-target="#modalEliminar"><i class="fas fa-trash-alt"></i></a>
    							@endif
    							</div>
    						</td>
    					</tbody>
    					@endforeach
    				</table>
    				{!!$ciudades->appends(request()->input())->render()!!}
    			@else
    				<hr>
    				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> 
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> <strong>Upps!</strong> No se encontraron resultados.
    				</div>
    			@endif
    		@else
				<hr>
				<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin-bottom:0;"> <strong>Upps!</strong> No tienes permiso para ver los listados.
				</div>
    		@endif
		</div>
	</div>
@stop
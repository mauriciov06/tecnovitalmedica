@extends('layouts.admin')

@section('content')
	<div class="content-section-modulo">
		<div class="sub-nav-item">
			<h4>Listado de Procesos de Mantenimiento</h4>
		</div>

		<div class="users">
		    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
    		    <?php $valid = false; ?>
    		    @if(count($procesos) > 0)
        			<table class="table table-sty" style="margin-top: 15px;">
        				<thead>
        					<th>Nombre del archivo</th>
        					<th>Archivo</th>
        					<th>Fecha de realización</th>
        					@if(Auth::user()->tipo_cuenta == 1)
        					    <th>Acción</th>
        					@endif
        				</thead>
        				
        				<tbody>
            				@foreach($procesos as $proceso)
            					<tr>
            						<td class="first-item-table">
            							{{$proceso->nombre_archivo}}
            						</td>
            						<td>
            						    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
            							    <a href="/listado_instituciones/{{$proceso->nombre_carpeta_institucion}}/Procesos/{{$proceso->nombre_archivo}}" target="_blank" class="btn btn-primary">Ver Archivo</a>
            							@endif
            						</td>
            						<td>
            							<?php echo date("d-m-Y", strtotime($proceso->fecha_realizacion)); ?>
            						</td>
            						@if(Auth::user()->tipo_cuenta == 1)
            						<td>
            						    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
                						    <div style="display: inline-block;">
        									    <a title="Eliminar" class="btn btn-danger btn-eliminar" data-toggle="modal" data-idarchivo="{{$proceso->id}}" data-idinstitucion="{{$proceso->id_instituciones}}" data-idequipo="{{$proceso->id_equipo_medico}}" data-tipoarchivo="{{$proceso->tipo_archivo}}" data-nombrecarpeta="{{$proceso->nombre_carpeta_institucion}}" data-target="#modalEliminarArchivo"><i class="fas fa-trash-alt"></i></a>
        								    </div>
    								    @endif
            						</td>
            						@endif
            					</tr>
            				@endforeach
        				</tbody>
        			</table>
        			<?php $valid = true;  ?>
    			@endif
    			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 10px auto;">
    			    <?php if($valid == true){ ?>
    			        <strong>Genial!</strong> Sigue subiendo archivos.
    			    <?php }else{ ?>
    			        <strong>Upp!</strong> No hay procesos de mantenimiento registrados.
    			    <?php } ?>
    			    @if(Auth::user()->tipo_cuenta == 1)
    			        @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
            			    <a class="subirArchivo" data-idinstitucion="<?php echo $id; ?>" data-archivo="7" data-idequipo="0" data-toggle="modal" data-target="#fileManager">Subir Archivo</a>
            			@endif
    		  	    @endif
    		  	</div>
    		@else
    		    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 10px auto;">
    		        <strong>Upp!</strong> No tienes permisos para ver los listados.
    		    </div>
		  	@endif
		</div>
	</div>
@stop

@section('scripts')
	{!!Html::script('js/custom-file-input.js')!!}
@endsection

<div class="row">	
	<div class="col-xs-12 col-sm-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
		<div class="form-group">
			<output id="list">
			<?php if(!empty($equipo)){ ?>
				<img class="thumb" src="/avatares/{!!$equipo->url_imagen_equipo!!}" alt="">
			<?php } ?>
			</output>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Institución a la que pertenece:')!!}
		<div class="sty-campo">
			<?php 
				$institucions = json_decode($instituciones, true);
				foreach ($institucions as $id_institucion => $nombreInstitucion) {
					if($id_institucion == $equipo->id_instituciones){
						echo $nombreInstitucion;
					}
				}
			?>
		</div>
	</div>
	<div class="form-group">
		{!!Form::label('Modelo:')!!}
		<div class="sty-campo">{!!$equipo->modelo!!}</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<div class="form-group">
			{!!Form::label('Nombre del equipo:')!!}
			<div class="sty-campo">{!!$equipo->nombre_equipo_medico!!}</div>
		</div>
		<div class="form-group">
			{!!Form::label('Serie:')!!}
			<div class="sty-campo">{!!$equipo->serie!!}</div>
		</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Marca:')!!}
		<div class="sty-campo">{!!$equipo->marca!!}</div>
	</div>
	<div class="form-group">
		{!!Form::label('Activo Fijo:')!!}
		<div class="sty-campo">{!!$equipo->activo_fijo!!}</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="form-group">
		{!!Form::label('Ubicación:')!!}
		<div class="sty-campo">{!!$equipo->ubicacion!!}</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<hr style="display: inline-block;width: 100%;margin: 30px 0 38px;">
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <!-- Nav tabs -->
  <ul id="tab-procedimientos" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#hoja_vida" aria-controls="hoja_vida" role="tab" data-toggle="tab">Hoja de Vida</a></li>
    <li role="presentation"><a href="#mantenimientoP" aria-controls="mantenimientoP" role="tab" data-toggle="tab">Mto. Preventivo</a></li>
    <li role="presentation"><a href="#mantenimientoC" aria-controls="mantenimientoC" role="tab" data-toggle="tab">Mto. Correctivo</a></li>
    <li role="presentation"><a href="#calibraciones" aria-controls="calibraciones" role="tab" data-toggle="tab">Calibraciones</a></li>
    <li role="presentation"><a href="#guias" aria-controls="guias" role="tab" data-toggle="tab">Guias de manejo</a></li>
    <li role="presentation"><a href="#manuales" aria-controls="manuales" role="tab" data-toggle="tab">Manuales</a></li>
    <li role="presentation"><a href="#otros" aria-controls="otros" role="tab" data-toggle="tab">Otros</a></li>
  </ul>

  <!-- Tab panes -->
  <div id="tab-content-procedimientos" class="tab-content" style="padding: 25px 0;">
    <div role="tabpanel" class="tab-pane fade in active" id="hoja_vida">
        @if(isset($manager_institucion))
            <?php $valid = false; ?>
        	@foreach($manager_institucion as $manager_file)
    			@if($manager_file->tipo_archivo == 1)
    			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
    			        <div class="input-group">
    			            <label>{{$manager_file->nombre_archivo}}</label>
    			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
    			            <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Hoja de vida/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
    			            @endif
    			            
    			            @if(Auth::user()->tipo_cuenta == 1)
    			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
            				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="1" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
            				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            				            {!! Form::token() !!}
            				        </a>
        				        @endif
    				        @endif
    			        </div>
    			    </div>
    			    <?php $valid = true; ?>
    			@endif
    		@endforeach
        @endif
            
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="1" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="mantenimientoP">
        @if(count($manager_institucion) > 0)
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="form-group" style="margin-bottom:0;">
                          {!!Form::label('Fecha de inicio:')!!}
                          {!!Form::date('fecha_inicio', \Carbon\Carbon::now()->subDay(), ['class' => 'form-control fecha_inicio'])!!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="form-group" style="margin-bottom:0;">
                          {!!Form::label('Fecha final:')!!}
                          {!!Form::date('fecha_final', null, ['class' => 'form-control fecha_final'])!!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <div class="form-group">
                          <a class="buscarporfecha" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-tipoarchivo="2" data-nombrecarpeta="{{$equipo->nombre_carpeta_institucion}}"><i class="fas fa-search"></i> Buscar</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        <div class="listado-de-archivos">
            @if(isset($manager_institucion))
                <?php $valid = false; ?>
            	@foreach($manager_institucion as $manager_file)
        			@if($manager_file->tipo_archivo == 2)
        			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
        			        <div class="input-group">
        			            <label>{{$manager_file->nombre_archivo}}</label>
        			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
        			            <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Mantenimiento Preventivo/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
        			            @endif
        			            
        			            @if(Auth::user()->tipo_cuenta == 1)
        			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
                				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="2" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
                				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                				            {!! Form::token() !!}
                				        </a>
            				        @endif
        				        @endif
        			        </div>
        			    </div>
        			    <?php $valid = true; ?>
        			@endif
        		@endforeach
            @endif
        </div>
        
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="2" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
    <div role="tabpanel" class="tab-pane fade in" id="mantenimientoC">
        @if(count($manager_institucion) > 0)
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="form-group" style="margin-bottom:0;">
                          {!!Form::label('Fecha de inicio:')!!}
                          {!!Form::date('fecha_inicio', \Carbon\Carbon::now()->subDay(), ['class' => 'form-control fecha_inicio'])!!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="form-group" style="margin-bottom:0;">
                          {!!Form::label('Fecha final:')!!}
                          {!!Form::date('fecha_final', null, ['class' => 'form-control fecha_final'])!!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <div class="form-group">
                          <a class="buscarporfecha" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-tipoarchivo="3" data-nombrecarpeta="{{$equipo->nombre_carpeta_institucion}}"><i class="fas fa-search"></i> Buscar</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        
        <div class="listado-de-archivos">
            @if(isset($manager_institucion))
            	<?php $valid = false;?>
            	@foreach($manager_institucion as $manager_file)
        			@if($manager_file->tipo_archivo == 3)
        			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
        			        <div class="input-group">
        			            <label>{{$manager_file->nombre_archivo}}</label>
        			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
        			                <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Mantenimiento Correctivo/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
        			            @endif
        			            
        			            @if(Auth::user()->tipo_cuenta == 1)
        			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
                				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="3" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
                				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                				            {!! Form::token() !!}
                				        </a>
            				        @endif
        				        @endif
        			        </div>
        			    </div>
        			    <?php $valid = true; ?>
        			@endif
        		@endforeach
            @endif
        </div>
        
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="3" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
    <div role="tabpanel" class="tab-pane fade" id="calibraciones">
        @if(count($manager_institucion) > 0)
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="form-group" style="margin-bottom:0;">
                          {!!Form::label('Fecha de inicio:')!!}
                          {!!Form::date('fecha_inicio', \Carbon\Carbon::now()->subDay(), ['class' => 'form-control fecha_inicio'])!!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="form-group" style="margin-bottom:0;">
                          {!!Form::label('Fecha final:')!!}
                          {!!Form::date('fecha_final', null, ['class' => 'form-control fecha_final'])!!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <div class="form-group">
                          <a class="buscarporfecha" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-tipoarchivo="4" data-nombrecarpeta="{{$equipo->nombre_carpeta_institucion}}"><i class="fas fa-search"></i> Buscar</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endif
        
        <div class="listado-de-archivos">
            @if(isset($manager_institucion))
            	<?php $valid = false;?>
            	@foreach($manager_institucion as $manager_file)
        			@if($manager_file->tipo_archivo == 4)
        			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
        			        <div class="input-group">
        			            <label>{{$manager_file->nombre_archivo}}</label>
        			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
        			                <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Calibraciones/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
        			            @endif
        			            
        			            @if(Auth::user()->tipo_cuenta == 1)
        			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
                				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="4" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
                				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
                				            {!! Form::token() !!}
                				        </a>
            				        @endif
        				        @endif
        			        </div>
        			    </div>
        			    <?php $valid = true; ?>
        			@endif
        		@endforeach
            @endif
        </div>
        
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="4" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
    <div role="tabpanel" class="tab-pane fade" id="guias">
        @if(isset($manager_institucion))
    	    <?php $valid = false;?>
        	@foreach($manager_institucion as $manager_file)
    			@if($manager_file->tipo_archivo == 5)
    			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
    			        <div class="input-group">
    			            <?php 
    			                $nombreRecortado = substr($manager_file->nombre_archivo, 11);
    			            ?>
    			            <label><?php echo $nombreRecortado; ?></label>
    			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
    			                <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Guias/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
    			            @endif
    			            @if(Auth::user()->tipo_cuenta == 1)
    			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
            				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="5" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
            				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            				            {!! Form::token() !!}
            				        </a>    
        				        @endif
    				        @endif
    			        </div>
    			    </div>
    			    <?php $valid = true; ?>
    			@endif
    		@endforeach
		@endif
        
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="5" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
    <div role="tabpanel" class="tab-pane fade" id="manuales">
        @if(isset($manager_institucion))
    	    <?php $valid = false;?>
        	@foreach($manager_institucion as $manager_file)
    			@if($manager_file->tipo_archivo == 6)
    			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
    			        <div class="input-group">
    			            <?php 
    			                $nombreRecortado2 = substr($manager_file->nombre_archivo, 11);
    			            ?>
    			            <label><?php echo $nombreRecortado2; ?></label>
    			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
    			                <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Manuales/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
    			            @endif
    			            @if(Auth::user()->tipo_cuenta == 1)
    			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
            				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="6" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
            				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            				            {!! Form::token() !!}
            				        </a>
        				        @endif
    				        @endif
    			        </div>
    			    </div>
    			    <?php $valid = true; ?>
    			@endif
    		@endforeach
        @endif
        
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="6" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
    <div role="tabpanel" class="tab-pane fade" id="otros">
        @if(isset($manager_institucion))
    	    <?php $valid = false;?>
        	@foreach($manager_institucion as $manager_file)
    			@if($manager_file->tipo_archivo == 8)
    			    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" id="documento-{{$manager_file->id}}">
    			        <div class="input-group">
    			            <?php 
    			                $nombreRecortado3 = substr($manager_file->nombre_archivo, 11);
    			            ?>
    			            <label><?php echo $nombreRecortado3; ?></label>
    			            @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 4))
    			                <a href="/listado_instituciones/{{$manager_file->nombre_carpeta_institucion}}/Otros/{{$manager_file->nombre_archivo}}" target="_blank" class="btn ver-archivo">Ver Archivo</a>
    			            @endif
    			            @if(Auth::user()->tipo_cuenta == 1)
    			                @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 3))
            				        <a class="btn-eliminar" data-idinstitucion="{!!$manager_file->id_instituciones!!}" data-data-idequipo="{!!$manager_file->id_equipo_medico!!}" data-idarchivo="{{$manager_file->id}}" data-nombrecarpeta="{{$manager_file->nombre_carpeta_institucion}}" data-tipoarchivo="8" id="{{$manager_file->id}}" data-target="#modalEliminarArchivo" data-toggle="modal">
            				            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            				            {!! Form::token() !!}
            				        </a>
        				        @endif
    				        @endif
    			        </div>
    			    </div>
    			    <?php $valid = true; ?>
    			@endif
    		@endforeach
        @endif
        
        @if(Auth::user()->tipo_cuenta == 1)
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
			        <?php if($valid == true){ ?>
				        <strong>Genial!</strong> Sigue subiendo archivos. 
				    <?php }else{ ?>
				        <strong>Upp!</strong> No hay archivo registrado. 
				    <?php } ?>
				    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 5))
				        <a class="subirArchivo" data-idinstitucion="{!!$equipo->id_instituciones!!}" data-idequipo="{!!$equipo->id!!}" data-archivo="8" data-toggle="modal" data-target="#fileManager">Subir Archivo</a> 
				    @endif
			    </div>
		    </div>
    	@else
    	    <?php if($valid == false){ ?>
        	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        			<div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 0;">
    				        <strong>Lo sentimos!</strong> Aun no se ha subido el archivo.
        			</div>
        		</div>
    		<?php } ?>
    	@endif
    </div>
  </div>
</div>

<div id="delete-doc-msg" style="display: inline-block;width: 100%;"></div>
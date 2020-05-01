<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tecnologia Vital Medica | Admin</title>
    
    {!!Html::style('css/admin.css')!!}
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/all.min.css')!!}
    {!!Html::style('css/select2.min.css')!!}
    {!!Html::style('css/selectize.bootstrap3.css')!!}
</head>

<body>
    
  <nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="col-sm-3 col-md-3" style="border-right: 1px solid #ccc;">
      <div class="navbar-header header-left-admin">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{!!URL::to('/admin')!!}">
          <img class="logo-admin" src="/imagenes/log-tvmsas.png" alt="">
        </a>
      </div>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="col-sm-9 col-md-9">
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a style="padding: 15px;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
              <img src="/avatares/{!!Auth::user()->avatar!!}" width="50" height="50" class="img-circle" style="margin-right: 5px;">   {!!Auth::user()->name!!}   <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <div class="media" style="padding: 6px 15px;">
                <div class="media-left">
                  <img src="/avatares/{!!Auth::user()->avatar!!}" width="80" height="80" class="media-object" style="border-radius: 10px;">
                </div>
                <div class="media-body">
                  <p>Bienvenido, <strong>{!!Auth::user()->name!!}</strong></p>
                  
                </div>
              </div>
              <li role="separator" class="divider"></li>
              <li><a href="/usuarios/{!!Auth::user()->id !!}/edit">Editar perfil</a></li>
              <li><a href="{!!URL::to('/logout')!!}">Cerrar Sesión</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-3 sidebar">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          @if(Auth::user()->tipo_cuenta == 1)
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <a class="active" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Usuarios <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                  </a>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <ul>
                    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
        			    <li><a href="{!!URL::to('/usuarios/create')!!}">Agregar Usuario</a></li>
        			@endif
        			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
        			    <li><a href="{!!URL::to('/usuarios')!!}">Listar Usuarios</a></li>
        			@endif
                  </ul>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingFive">
                <h4 class="panel-title">
                  <a class="active" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                    Ciudades <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                  </a>
                </h4>
              </div>
              <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                <div class="panel-body">
                  <ul>
                    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
        			    <li><a href="{!!URL::to('/ciudades')!!}">Listar Ciudades</a></li>
        			@endif
                  </ul>
                </div>
              </div>
            </div>
          @endif
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
              <h4 class="panel-title">
                @if(Auth::user()->tipo_cuenta == 1)
                  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Instituciones <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                  </a>
                @else
                  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Institución Asociada <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                  </a>
                @endif
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
              <div class="panel-body">
                <ul>
                  @if(Auth::user()->tipo_cuenta == 1)
                    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
        			    <li><a href="{!!URL::to('/instituciones/create')!!}">Agregar Institución</a></li>
        			@endif
        			@if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
        			    <li><a href="{!!URL::to('/instituciones')!!}">Listar Instituciones</a></li>
        			@endif
                  @else
                    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
        			    <li><a href="{!!URL::to('/instituciones')!!}">Procesos de Mantenimiento</a></li>
        			@endif
                  @endif
                </ul>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
              <h4 class="panel-title">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Equipos Medicos <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                </a>
              </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
              <div class="panel-body">
                <ul>
                  @if(Auth::user()->tipo_cuenta == 1)
                    @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 1))
                        <li><a href="{!!URL::to('/equipos/create')!!}">Agregar Equipo Medico</a></li>
                    @endif
                  @endif
                  @if(Tecnovitalmedica\Http\Controllers\UsuarioController::getPermisos(Auth::user()->id, 6))
                        <li><a href="{!!URL::to('/equipos')!!}">Listar Equipos Medicos</a></li>
                    @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3 main content-right-main">
        <div class="content-main">
          @include('alerts.sucess')
          @include('alerts.errors')
          @include('alerts.request')
          @include('modal_eliminar')
          @include('instituciones.modalcrearcontacto', ['ciudades'=>Tecnovitalmedica\Http\Controllers\CiudadController::getCiudades()])
          @include('instituciones.modalactualizarcontacto', ['ciudades'=>Tecnovitalmedica\Http\Controllers\CiudadController::getCiudades()])
          @include('ciudades.modalcrearciudad')
          @include('ciudades.modaleditarciudad')
          @include('file-manager.modal_file_manager')
          @include('modal_eliminarArchivos')
          @yield('content')
        </div>
      </div>
    </div>
  </div>
  

    {!!Html::script('js/jquery.min.js')!!}
    {!!Html::script('js/bootstrap.min.js')!!}
    {!!Html::script('js/script.js')!!}
    {!!Html::script('js/select2.min.js')!!}
    {!!Html::script('js/selectize.js')!!}
    <script>
        jQuery(document).ready(function() {
            jQuery('#permisos').selectize({
                valueField: 'id',
                labelField: 'name',
                options:[{id:'1',name:'Crear'},{id:'2',name:'Editar'},{id:'3',name:'Eliminar'}, {id:'4',name:'Ver'},{id:'5',name:'Subir archivos'}, {id:'6',name:'Listar'}]
            });
        });
    </script>

  @section('scripts')
  @show

</body>

</html>

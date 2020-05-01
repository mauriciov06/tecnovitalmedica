<!DOCTYPE html>
<html>
  <head>
    <title>Inicio de Session</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {!!Html::style('css/admin.css')!!}
    {!!Html::style('css/bootstrap.min.css')!!}
    

  </head>
  <body class="body-login">

    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 sidebar-left">
          <a href="{!!URL::to('/')!!}" class="header-login">
            <img class="img-responsive" src="/imagenes/logo-mvtsas-2.png" style="margin: auto;" alt="">
          </a>
          <div class="content-login">
            <h3>Iniciar Sesion</h3>  
            {!!Form::open(['route'=>'log.store', 'method'=>'POST'])!!}
            <div class="form-group">
              {!!Form::label('Correo Electronico')!!}
              {!!Form::email('email', null,['class'=>'form-control'])!!}
            </div>
            <div class="form-group">
              {!!Form::label('Contraseña')!!}
              {!!Form::password('password', ['class'=>'form-control'])!!}
            </div>            
            <div class="form-group" style="display: inline-block;width: 100%;margin-bottom: 0;">
              @include('alerts.errors')
            </div>
            {!!Form::submit('Entrar',['class'=>'btn btn-login'])!!}
            <div class="form-group sty-in" style="display: block;margin-top: 9px;margin-bottom: 0;text-align: center;">
            </div>
            {!!Form::close()!!}
          </div>
        </div>
        <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-9 col-lg-9 col-md-offset-3 main-right">
          <img src="/imagenes/imagen-inicio-sesion.jpg" alt="">
        </div>
      </div>
    </div>

    {!!Html::script('js/jquery.min.js')!!}
    {!!Html::script('js/bootstrap.min.js')!!}
  </body>
</html>
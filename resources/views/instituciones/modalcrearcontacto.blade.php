<div class="modal fade" id="modalContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-cust-wit" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Crear Contacto</h4>
      </div>
      <div class="modal-body">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group">
          {!!Form::label('Nombre:')!!}
          {!!Form::text('name',null,['class'=>'form-control', 'id'=>'name_contacto'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Telefono:')!!}
          {!!Form::text('telefono',null,['class'=>'form-control', 'id'=>'telefono_contacto'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Celular:')!!}
          {!!Form::text('celular',null,['class'=>'form-control', 'id'=>'celular_contacto'])!!}
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="form-group">
          {!!Form::label('Correo Electronico:')!!}
          {!!Form::email('email',null,['class'=>'form-control', 'id'=>'email_contacto'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Ciudad:')!!}
          {!!Form::select('id_ciudad', $ciudades,null,['class'=>'form-control', 'id'=>'id_ciudad_contacto'])!!}
        </div>
        <div class="form-group">
          {!!Form::label('Contraseña:')!!}
          {!!Form::password('password',['class'=>'form-control', 'id'=>'password_contacto'])!!}
        </div>
        </div>
        {!!Form::hidden('id_usucontc','', ['id'=>'id_usucontc'])!!}
        {!!Form::hidden('id_institucion','', ['id'=>'id_institucion'])!!}
        <div id="mensaje-request"></div>
      </div>
      <div class="modal-footer">
      	<a class="btn btn-crear-contacto" id="crear-contacto" data-idinst="">Crear Contacto</a>
        <button type="button" class="btn btn-default-contacto" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
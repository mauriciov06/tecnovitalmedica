<div class="modal fade" id="modalEditarCiudad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-cust-wit modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Editar Ciudad</h4>
      </div>
      <div class="modal-body">
	    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              {!!Form::label('Nombre ciudad:')!!}
              {!!Form::text('nombre_ciudad',null,['class'=>'form-control', 'id'=>'nombre_ciudad_edit'])!!}
            </div>
        </div>
        <div id="mensaje-request-ciu-edi"></div>
      </div>
      <div class="modal-footer">
      	<a class="btn btn-crear-ciudad" id="editar-ciudad-confi" data-idciu="">Editar Ciudad</a>
        <button type="button" class="btn btn-default-ciudad" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
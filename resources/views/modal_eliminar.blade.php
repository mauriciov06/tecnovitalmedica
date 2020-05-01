<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-cust-wit" role="document" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirmación de eliminación</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        <p>Esta seguro de eliminar?</p>
        <div class="form-group">
          <input class="form-control" id="chapchat-pass" name="chapchat-pass" type="text">
          <small for="chapchat-pass" class="chapchat-pass">Ingrese los siguiente digitos para confirmar: <strong>12345</strong></small>
        </div>
        <div id="msg-eliminar-modal"></div>
      </div>
      <div class="modal-footer">
      	<a class="btn btn-eliminarConfi btn-danger" data-id="">Confirmar</a>
        <button type="button" class="btn btn-cancelar btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
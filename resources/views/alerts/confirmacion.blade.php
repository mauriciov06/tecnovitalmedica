<!-- Modal -->
<div class="modal fade" id="confirmacion_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        kalsksafsjala
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">Confriamr</button>
        {!!Form::open(['route'=> ['clientes.destroy', $user->id], 'method'=>'DELETE'])!!}
          {!!Form::submit('Eliminar',['class'=>'btn btn-danger'])!!}
        {!!Form::close()!!}
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
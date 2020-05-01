<!-- Modal -->
<div class="modal fade" id="fileManager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-cust-wit" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Subir Archivos</h4>
      </div>
      <form id="fileUpdateSysm" method='post' action="/filemanagers" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
          <div class="modal-body">
            @include('file-manager.forms.modalFormFile')
            <input type="hidden" id="id_institu" name="id_institu" />
            <input type="hidden" id="id_equipo" name="id_equipo" />
            <input type="hidden" id="tipo_archivo" name="tipo_archivo" />
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-createFileM">Guardar</button>
            <a class="btn btn-default-createFileM" data-dismiss="modal">Cerrar</a>
          </div>
      </form>
    </div>
  </div>
</div>
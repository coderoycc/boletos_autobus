<!-- MODAL EDITAR -->
<div class="modal fade" id="trip_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title text-white fs-5">Editar Viaje</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal_content_edit"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="trip_update()">Actualizar</button>
        </div>
      </div>
    </div>
</div>
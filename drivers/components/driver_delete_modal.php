 <!-- MODAL ELIMINAR -->
 <div class="modal fade" id="driver_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h1 class="modal-title text-white fs-5">¿DAR DE BAJA AL CHOFER?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <input type="hidden" id="driver_id_delete">
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" onclick="down_driver()">DAR DE BAJA</button>
        </div>
      </div>
    </div>
</div>
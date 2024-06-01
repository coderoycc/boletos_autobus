<div class="modal fade" tabindex="-1" id="select-client-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-secondary"><i class="fas fa-user me-2"></i>Seleccionar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <?php
                    include('components/client_data_form.php');
                ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn-create-client"><i class="fas fa-save me-2"></i>Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn-select-client"><i class="fas fa-id-card me-2"></i>Seleccionar</button>
      </div>
    </div>
  </div>
</div>
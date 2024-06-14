<!-- MODAL NEW LIQUIDATION DATA -->
<div class="modal fade" id="liquidation_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h1 class="modal-title text-white fs-5">AGREGAR DATOS A LIQUIDACIÓN</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="liquidation_form">
          <input type="hidden" name="trip_id" id="trip_id_modal" value="0">
          <input type="hidden" name="liquidation_id" id="liquidation_id_modal" value="0">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-3">
                <span class="input-group-text text-secondary fw-semibold" style="width: 300px;">Correspondencia y Encomiendas</span>
                <input type="number" step="any" class="form-control" name="correspondence" value="0">
              </div>
            </div>
            <div class="col-md-12">
              <div class="input-group mb-3">
                <span class="input-group-text text-secondary fw-semibold" style="width: 300px;">Otros Descuentos</span>
                <input type="number" class="form-control" step="any" name="other_amount" value="20">
              </div>
            </div>
          </div>
          <hr>
          <div class="d-flex">
            <label class="form-label text-secondary fw-semibold">Descuentos Adicionales</label>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3 align-self-center">
              <input type="text" class="form-control" name="other_concept" placeholder="Concepto descuento">
            </div>
            <div class="col-md-6 mb-3">
              <input type="number" class="form-control" step="any" name="other_concept_amount" value="0">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary text-white" id="liquidation_btn_modal">ENVIAR</button>
      </div>
    </div>
  </div>
</div>
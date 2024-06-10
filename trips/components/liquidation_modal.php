<!-- MODAL NEW LIQUIDATION DATA -->
<div class="modal fade" id="liquidation_data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h1 class="modal-title text-white fs-5">AGREGAR DATOS A LIQUIDACIÓN</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="liquidation_form" onsubmit="return false;">
          <input type="hidden" name="trip_id" id="trip_id_modal">
          <div class="row">
            <div class="col-md-6 align-self-center fs-5 text-center text-md-end">
              Otros descuentos
            </div>
            <div class="col-md-6 mb-3">
              <input type="number" class="form-control" step="any" name="other_amount" value="20">
            </div>
            <hr>
            <div class="col-md-6 mb-3 align-self-center">
              <input type="text" class="form-control" name="other_concept" placeholder="Concepto otro descuento">
            </div>
            <div class="col-md-6 mb-3">
              <input type="number" class="form-control" step="any" name="other_concept_amount" value="" placeholder="0.0">
            </div>
          </div>
          <div class="my-3">
            <label class="form-label">Correspondencia y enconmiendas </label>
            <input type="number" type="any" class="form-control" name="correspondence" placeholder="0.0">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal" id="liquidation_btn_modal">ENVIAR</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="ticket-consolidate-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-bg-warning">
        <h5 class="modal-title"><i class="fas fa-bus me-2"></i>Consolidar Venta</h5>
      </div>
      <div class="modal-body">
        <form id="consolidate-ticket-form">
            <div class="row">
                <div class="col-md-12" id="ticket-detail-consolidate">
                    <table class="table table-bordered">
                        <thead class="text-bg-info fw-semibold">
                            <tr>
                                <td colspan="2"><i class="fas fa-id-badge me-2"></i>Datos de la Reserva</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-secondary">Cliente:</td>
                                <td id="txt-client"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-secondary">Adelanto:</td>
                                <td id="txt-advance"></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-secondary">Asiento:</td>
                                <td id="txt-seat"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">    
                    <input type="hidden" value="" id="client-id" name="client_id" />
                    <label class="form-label text-secondary fw-semibold ms-2" for="ticket-consolidate-price" id="labelPrecioPagar">Precio a Pagar</label>
                    <input type="number" class="form-control" id="ticket-consolidate-price" placeholder="Ingresar precio restante" value="" name="price2" required>
                    <input type="hidden" class="form-control" id="ticket-consolidate-price-divided" value="0" name="price">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cerrar</button>
        <button type="button" class="btn btn-warning" id="btn-consolidate-ticket"><i class="fas fa-save me-2"></i>Consolidar Venta</button>
      </div>
    </div>
  </div>
</div>
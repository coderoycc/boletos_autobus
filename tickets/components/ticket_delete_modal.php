<div class="modal fade" tabindex="-1" id="ticket-delete-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-bg-danger">
        <h5 class="modal-title">Eliminar Boleto</h5>
      </div>
      <div class="modal-body">
        <form id="delete-ticket-form">
          <div class="row">
              <div class="col-md-12" id="ticket-detail">
                <div class="alert alert-danger" role="alert">
                  <p class="m-0">
                      ¿Esta seguro(a) que desea eliminar la venta del boleto?<br>
                      <strong> Ingrese su contraseña actual para confirmar. </strong>.
                  </p>
                </div>
              </div>
              <div class="col-md-12">
                <label class="form-label text-secondary fw-semibold ms-2" for="password-user">Contraseña</label>
                <input type="hidden" value="" id="ticket-id-delete" name="id" />
                <input type="password" class="form-control" id="ticket-password-confirm" placeholder="Ingresar contraseña" value="" name="password" min="4" required>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cerrar</button>
        <button type="button" class="btn btn-danger" id="btn-delete-ticket"><i class="fas fa-trash me-2"></i>Eliminar</button>
      </div>
    </div>
  </div>
</div>
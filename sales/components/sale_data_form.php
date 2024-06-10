<form id="sale-data-form">
    <div class="card">
        <div class="card-header text-bg-primary">
            <div class="card-title fw-semibold m-0"><i class="fas fa-bus me-2"></i>Datos de la Venta</div>
        </div>
        <div class="card-body">
            <div class="row">
                <input type="hidden" id="cliente-selected" name="client_id">
                <input type="hidden" id="trip-id" name="trip_id">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold text-secondary" for="locations">Destino Intermedio</label>
                    <select class="form-select" id="locations" name="intermediate_id"></select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="numero-asiento" class="form-label text-secondary fw-semibold">Asiento:</label>
                    <input type="number" class="form-control" id="numero-asiento" name="seat_number" placeholder="Número de Asiento" autocomplete="off" readonly required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="precio-asiento" class="form-label text-secondary fw-semibold">Precio:</label>
                    <input type="number" class="form-control" id="precio-asiento" name="price" placeholder="Total a Pagar" autocomplete="off" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label text-secondary fw-semibold">Tipo de Venta:</label>
                </div>
                <div class="col-md-12">
                    <div class="input-group justify-content-center">
                        <input type="radio" class="btn-check" name="status" id="radio-sale" autocomplete="off" value="VENDIDO" checked>
                        <label class="btn btn-outline-secondary" for="radio-sale">VENTA DIRECTA</label><br>
                        <input type="radio" class="btn-check" name="status" id="radio-reservation" autocomplete="off" value="RESERVA">
                        <label class="btn btn-outline-secondary" for="radio-reservation">RESERVAR BOLETO</label><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
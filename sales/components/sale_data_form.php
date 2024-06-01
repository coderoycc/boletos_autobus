<div class="card">
    <div class="card-header">
        <div class="card-title fw-semibold text-secondary m-0"><i class="fas fa-bus me-2"></i>Datos de la Venta</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="numero-asiento" class="form-label text-secondary fw-semibold">Cliente:</label>
                <input type="number" class="form-control" id="documento-cliente" placeholder="Nro. de documento" readonly>
                <input type="hidden" id="cliente-selected" name="cliente">
            </div>
            <div class="col-md-4 mb-3">
                <label for="numero-asiento" class="form-label text-secondary fw-semibold">Asiento:</label>
                <input type="number" class="form-control" id="numero-asiento" name="numero" placeholder="Número de Asiento" autocomplete="off" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="precio-asiento" class="form-label text-secondary fw-semibold">Precio:</label>
                <input type="number" class="form-control" id="precio-asiento" name="precio" placeholder="Total a Pagar" autocomplete="off">
            </div>
        </div>
    </div>
</div>
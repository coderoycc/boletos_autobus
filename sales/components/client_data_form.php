<div class="card">
    <div class="card-header text-bg-primary">
        <div class="card-title fw-semibold m-0"><i class="fas fa-bus me-2"></i>Datos del cliente</div>
    </div>
    <div class="card-body">
        <form id="client-data-form">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ci-cliente" class="form-label text-secondary fw-semibold">Cédula de Identidad:</label>
                    <input type="number" class="form-control" id="ci-cliente" name="ci" placeholder="CI" autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nit-cliente" class="form-label text-secondary fw-semibold">N.I.T.:</label>
                    <input type="number" class="form-control" id="nit-cliente" name="nit" placeholder="NIT" autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nombre-cliente" class="form-label text-secondary fw-semibold">Nombre(s):</label>
                    <input type="text" class="form-control" id="nombre-cliente" name="name" placeholder="Nombres" autocomplete="off" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="paterno-cliente" class="form-label text-secondary fw-semibold">Apellido(s):</label>
                    <input type="text" class="form-control" id="paterno-cliente" name="lastname" placeholder="Apellidos" autocomplete="off" required>
                </div>
            </div>
            <div class="d-flex">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="check-menor" name="is_minor">
                    <label class="form-check-label" for="check-menor">
                        Es menor de edad
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>
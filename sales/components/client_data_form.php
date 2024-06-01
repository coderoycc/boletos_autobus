<form id="form-client-data">
    <input type="hidden" value="" checked id="id-cliente">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="ci-cliente" class="form-label text-secondary fw-semibold">Cédula de Identidad:</label>
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="ci" id="radio-ci" checked name="filter">
                </div>
                <input type="number" class="form-control" id="ci-cliente" name="ci" placeholder="CI" autocomplete="off" required>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="nit-cliente" class="form-label text-secondary fw-semibold">N.I.T.:</label>
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" value="nit" name="filter">
                </div>
                <input type="number" class="form-control" id="nit-cliente" name="nit" placeholder="NIT" autocomplete="off">
            </div>
        </div>
        <div class="col-md-4 mb-3 align-self-center">
            <button type="button" class="btn btn-outline-secondary w-100" id="btn-search-client"><i class="fas fa-search me-2"></i>Buscar</button>
        </div>
        <div class="col-md-4 mb-3">
            <label for="nombre-cliente" class="form-label text-secondary fw-semibold">Nombre(s):</label>
            <input type="text" class="form-control" id="nombre-cliente" name="name" placeholder="Nombres" autocomplete="off" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="paterno-cliente" class="form-label text-secondary fw-semibold">Ap. Paterno:</label>
            <input type="text" class="form-control" id="paterno-cliente" name="lastname" placeholder="Apellido Paterno" autocomplete="off" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="materno-cliente" class="form-label text-secondary fw-semibold">Ap. Materno:</label>
            <input type="text" class="form-control" id="materno-cliente" name="mothers_lastname" placeholder="Apellido Materno" autocomplete="off" required>
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
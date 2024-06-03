<div class="card my-3">
  <div class="card-header text-secondary fs-5 fw-semibold">
    + Agregar nuevo bus
  </div>
  <div class="card-body">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="placa" placeholder="Placa">
      <label for="placa">Placa</label>
    </div>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="description" placeholder="Descripcion">
      <label for="description">Descripción</label>
    </div>
    <div class="form-floating">
      <select class="form-select" id="distro_type" placeholder="Tipo de distribucion de asientos">
        <option value="">--- seleccione ---</option>
        <?php foreach($distros as $distro): ?>
          <option value="<?= $distro['id'] ?>"><?= $distro['description'] ?></option>
        <?php endforeach; ?>
      </select>
      <label for="distro_type">Distribución de asientos</label>
    </div>
  </div>
  <div class="card-footer d-flex justify-content-center">
    <button type="button" class="btn btn-success">GUARDAR</button>
  </div>
</div>
<div class="card my-3">
  <div class="card-header text-secondary fs-5 fw-semibold">
    + Agregar nuevo bus
  </div>
  <div class="card-body">
    <form id="data-bus-form">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="placa" placeholder="Placa" name="plate" required>
      <label for="placa">Placa</label>
    </div>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="description" placeholder="Descripcion" name="description" required>
      <label for="description">Descripción</label>
    </div>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="color" placeholder="Color" name="color" required>
      <label for="color">Color</label>
    </div>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="brand" placeholder="Marca" name="brand" required>
      <label for="brand">Marca</label>
    </div>
    <div class="form-floating">
      <select class="form-select" id="distro_type" placeholder="Tipo de distribucion de asientos" name="distribution_id" required>
        <option value="">--- seleccione ---</option>
        <?php foreach($distros as $distro): ?>
          <option value="<?= $distro['id'] ?>"><?= $distro['description'] ?></option>
        <?php endforeach; ?>
      </select>
      <label for="distro_type">Distribución de asientos</label>
    </div>
    </form>
  </div>
  <div class="card-footer d-flex justify-content-center">
    <button type="button" class="btn btn-success" onclick="createNewBus()"><i class="fas fa-save me-2"></i>Guardar</button>
  </div>
</div>
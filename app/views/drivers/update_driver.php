<div class="modal-header text-bg-primary">
  <h1 class="modal-title fw-semibold fs-5"><i class="fas fa-user me-2"></i>Actualizar Datos del Conductor</h1>
</div>
<div class="modal-body">
  <form id="data-driver-update-form">
    <div class="form-floating mb-3">
      <input type="hidden" name="id" required value="<?= $driver->id ?>">
      <input type="text" class="form-control" id="fullname" placeholder="Conductor" name="fullname" required value="<?= $driver->fullname ?>">
      <label for="fullname">Conductor</label>
    </div>
    <div class="form-floating mb-3">
      <input type="number" class="form-control" id="license" placeholder="Numero de Licencia" name="license" required value="<?= $driver->license ?>">
      <label for="license">Número de Licencia</label>
    </div>
    <div class="form-floating mb-3">
      <select class="form-select" id="category" placeholder="Tipo de categoría" name="category" required>
        <option value="">--- seleccione ---</option>
        <option value="A" <?= ($driver->category == "A" ? "selected" : "") ?>>A</option>
        <option value="B" <?= ($driver->category == "B" ? "selected" : "") ?>>B</option>
        <option value="C" <?= ($driver->category == "C" ? "selected" : "") ?>>C</option>
      </select>
      <label for="category">Categoria</label>
    </div>
    <div class="input-group">
      <div class="form-floating">
        <input type="number" class="form-control" id="discount-rate" placeholder="Porcentaje de Descuento" name="discount_rate" required value="<?= $driver->discount_rate ?>">
        <label for="discount-rate">Porcetaje de Descuento</label>
      </div>
      <span class="input-group-text"><b class="ms-2 me-2">%</b></span>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" onclick="updateDataDriver()"><i class="fas fa-sync-alt me-2"></i>Actualizar</button>
</div>
<div class="modal-header text-bg-success">
  <h1 class="modal-title fw-semibold fs-5"><i class="fas fa-user-plus me-2"></i>Agregar Nuevo Conductor</h1>
</div>
<div class="modal-body">
  <form id="data-driver-form">
    <div class="form-floating mb-3">
      <input type="text" class="form-control" id="fullname" placeholder="Conductor" name="fullname" required>
      <label for="fullname">Conductor</label>
    </div>
    <div class="form-floating mb-3">
      <input type="number" class="form-control" id="license" placeholder="Numero de Licencia" name="license" required>
      <label for="license">Número de Licencia</label>
    </div>
    <div class="form-floating mb-3">
      <select class="form-select" id="category" placeholder="Tipo de categoría" name="category" required>
        <option value="">--- seleccione ---</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
      </select>
      <label for="category">Categoría</label>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cerrar</button>
  <button type="button" class="btn btn-success" onclick="createNewDriver()"><i class="fas fa-save me-2"></i>Guardar</button>
</div>
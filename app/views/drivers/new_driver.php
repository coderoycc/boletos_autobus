<div class="card my-3">
  <div class="card-header text-secondary fs-5 fw-semibold">
    + Agregar Nuevo Conductor
  </div>
  <div class="card-body">
    <form id="data-driver-form">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="fullname" placeholder="Conductor" name="fullname" required>
        <label for="fullname">Conductor</label>
      </div>
      <div class="form-floating mb-3">
        <input type="number" class="form-control" id="license" placeholder="Numero de Licencia" name="license" required>
        <label for="license">Número de Licencia</label>
      </div>
      <div class="form-floating">
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
  <div class="card-footer d-flex justify-content-center">
    <button type="button" class="btn btn-success" onclick="createNewDriver()"><i class="fas fa-save me-2"></i>Guardar</button>
  </div>
</div>
<!-- MODAL AGREGAR -->
<div class="modal fade" id="trip_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title text-white fs-5">AGREGAR NUEVO VIAJE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="form_add_trip" onsubmit="return false;">
            <div class="row">
              <div class="col-md-6 mb-2">
                <div class="form-floating">
                  <input type="date" class="form-control" name="departure_date" placeholder="Fecha" value="<?= date('Y-m-d') ?>">
                  <label for="">Fecha de salida</label>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="form-floating">
                  <input type="time" class="form-control" name="departure_time" placeholder="Hora salida" value="<?= date('H:i') ?>">
                  <label>Hora de salida</label>
                </div>
              </div>
              <div class="col-md-12 my-2">
                <div class="form-floating">
                  <select class="form-select" id="add_trip_origen" name="origin" required></select>
                  <label for="destination">Lugar de origen</label>
                </div>
              </div>
              <div class="col-md-12 my-2">
                <div class="form-floating">
                  <select class="form-select" id="add_trip_destination" name="destination" required></select>
                  <label for="add_trip_destination">Lugar destino</label>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="form-floating">
                  <input type="number" step="any" class="form-control" name="min_price" placeholder="0.0">
                  <label for="">Precio mínimo</label>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="form-floating">
                  <input type="number" step="any" class="form-control" name="price" placeholder="0.0">
                  <label>Precio</label>
                </div>
              </div>
              <div class="col-md-12 my-2">
                <div class="form-floating">
                  <select class="form-select" id="buses_selected" name="bus" required></select>
                  <label for="buses_selected">Bus encargado</label>
                </div>
              </div>
              <div class="col-md-12 my-2">
                <div class="form-floating">
                  <select class="form-select" id="drivers_selected" name="driver_id" required></select>
                  <label for="drivers_selected">Conductor Designado</label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary text-white" data-bs-dismiss="modal" onclick="add_trip()">Agregar</button>
        </div>
      </div>
    </div>
</div>
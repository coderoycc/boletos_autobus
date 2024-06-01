<form id="form_edit_trip" onsubmit="return false;">
  <input type="hidden" name="trip_id" value="<?= $trip->id ?>">
  <div class="row">
    <div class="col-md-6 mb-2">
      <div class="form-floating">
        <input type="date" class="form-control" name="departure_date" placeholder="Fecha" value="<?= $trip->departure_date ?>">
        <label for="">Fecha de salida</label>
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <div class="form-floating">
        <input type="time" class="form-control" name="departure_time" placeholder="Hora salida" value="<?= $trip->departure_time ?>">
        <label>Hora de salida</label>
      </div>
    </div>
    <div class="col-md-12 my-2">
      <div class="form-floating">
        <select class="form-select" id="edit_trip_origen" name="origin" required>
          <?php foreach ($locations as $location) : ?>
            <option value="<?= $location['id'] ?>" <?= $location['id'] == $trip->location_id_origin ? 'selected' : '' ?>><?= strtoupper($location['location']) ?></option>
          <?php endforeach; ?>
        </select>
        <label for="destination">Lugar de origen</label>
      </div>
    </div>
    <div class="col-md-12 my-2">
      <div class="form-floating">
        <select class="form-select" id="edit_trip_destination" name="destination" required>
          <?php foreach ($locations as $location) : ?>
            <?php if ($location['id'] != $trip->location_id_origin) : ?>
              <option value="<?= $location['id'] ?>" <?= $location['id'] == $trip->location_id_dest ? 'selected' : '' ?>><?= strtoupper($location['location']) ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
        <label for="edit_trip_destination">Lugar destino</label>
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <div class="form-floating">
        <input type="number" step="any" class="form-control" name="min_price" placeholder="0.0" value="<?= $trip->min_price ?>">
        <label for="">Precio mínimo</label>
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <div class="form-floating">
        <input type="number" step="any" class="form-control" name="price" placeholder="0.0" value="<?= $trip->price ?>">
        <label>Precio</label>
      </div>
    </div>
    <div class="col-md-12 my-2">
      <div class="form-floating">
        <select class="form-select" id="buses_edit" name="bus">
          <?php foreach ($buses as $bus) : ?>
            <option value="<?= $bus['id'] ?>" <?= $bus['id'] == $trip->bus_id ? 'selected' : '' ?>><?= $bus['placa'] ?> | <?= substr($bus['description'], 0, 11) ?></option>
          <?php endforeach; ?>
        </select>
        <label for="buses_edit">Bus encargado</label>
      </div>
    </div>
  </div>
</form>
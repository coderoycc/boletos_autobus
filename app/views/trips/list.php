  <div class="row d-flex justify-content-center">
    <div class="col-md-5 d-flex flex-wrap justify-content-around">
      <p class="fs-4 fw-semibold text-secondary mb-0">Viajes de la fecha</p>
      <div class="input-group " style="width:auto !important;">
        <input type="date" id="trip_date" class="fw-semibold border-secondary text-secondary form-control" value="<?= $date ?>">
        <button class="btn btn-outline-secondary" type="button" id="list_search"><i class="fa-lg fa fa-solid fa-search"></i></button>
      </div>
    </div>
  </div>

  <table class="table table-striped" id="table_trips" width="100%">
    <thead>
      <tr class="text-center">
        <th>ID</th>
        <th>Fecha</th>
        <th>Hora de salida</th>
        <th>Placa Bus</th>
        <th>Origen</th>
        <th>Destino</th>
        <th>Precio Mínimo</th>
        <th>Precio</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($trips as $trip) : ?>
        <tr>
          <td class="text-center"><?= $trip['id'] ?></td>
          <td class="text-center"><?= date('d/m/Y', strtotime($trip['departure_date'])) ?></td>
          <td class="text-center"><?= date('H:i', strtotime($trip['departure_time'])) ?></td>
          <td class="text-center"><?= strtoupper($trip['placa']) ?></td>
          <td class="text-center"><?= strtoupper($trip['origen']) ?></td>
          <td class="text-center"><?= strtoupper($trip['destino']) ?></td>
          <td class="text-end"><?= number_format($trip['min_price'], 2) ?></td>
          <td class="text-end"><?= number_format($trip['price'], 2) ?></td>
          <td class="text-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <a href="../sales/?trip_id=<?= $trip['id'] ?>" type="button" class="btn btn-outline-success"><i class="fa-lg fa-solid fa-hand-holding-dollar"></i> Vender Boletos</a>
              <button type="button" class="btn btn-outline-primary" data-bs-target="#trip_edit" data-bs-toggle="modal" data-id="<?= $trip['id'] ?>"><i class="fa fa-solid fa-pen"></i> Editar</button>
              <a href="../reports/pdf/report_trip_clients.php?trip_id=<?= $trip['id'] ?>" type="button" class="btn btn-danger" target="_blank"><i class="fa-lg fa-solid fa-file-pdf"></i> Clientes</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
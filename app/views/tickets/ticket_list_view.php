<div class="card">
  <input type="hidden" value="<?= $trip_id ?>" id="current_trip_id">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered w-100" id="tickets-table">
        <thead class="text-center">
          <tr>
            <th rowspan="2">#</th>
            <th rowspan="2" class="table-success text-center">Bus</th>
            <th colspan="4" class="table-primary text-center">Viaje</th>
            <th colspan="4" class="table-warning text-center">Venta</th>
            <th rowspan="2">Acciones</th>
          </tr>
          <tr>
            <th class="table-primary">Origen</th>
            <th class="table-primary">Destino</th>
            <th class="table-primary">Salida</th>
            <th class="table-primary">Precio</th>
            <th class="table-warning">Asiento</th>
            <th class="table-warning">Usuario</th>
            <th class="table-warning">Fecha</th>
            <th class="table-warning">Cliente</th>
          </tr>
        </thead>
        <?php foreach ($records as $key => $record) { ?>
          <tr>
            <td class="text-center fw-bold"><?= ($key + 1) ?></td>
            <td><?= $record['bus_description'] ?></td>
            <td><?= strtoupper($record['origin']) ?></td>
            <td><?= strtoupper($record['destination']) . ' ' . (strlen($record['intermediate']) == 0 ? '' : '(' . strtoupper($record['intermediate']) . ')') ?></td>
            <td align="center"><?= (new DateTime($record['departure_date']))->format('d/m/Y') . " " . (new DateTime($record['departure_time']))->format('H:i') ?></td>
            <td class="fw-bold text-success text-center"><?= number_format($record['sold_price'], 2) . " Bs" ?></td>
            <td class="text-center fw-bold text-primary"><?= strtoupper($record['seat_number']) ?></td>
            <td align="center"><span class="badge text-bg-light"><?= strtoupper($record['username']) ?></span></td>
            <td align="center"><?= (new DateTime($record['sold_datetime']))->format('d/m/Y') . " " . (new DateTime($record['sold_datetime']))->format('H:i') ?></td>
            <td align="center"><?= $record['client'] ?></td>
            <td class="text-center">
              <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#ticket-detail-modal" data-ticket="<?= $record['ticket'] ?>"><i class="fas fa-qrcode"></i></button>
              <a class="btn btn-light me-2" href="../tickets/web_print.php?tid=<?= $record['ticket'] ?>" target="_blank"><i class="fas fa-file-pdf"></i></a>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ticket-delete-modal" data-ticket="<?= $record['ticket'] ?>"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>
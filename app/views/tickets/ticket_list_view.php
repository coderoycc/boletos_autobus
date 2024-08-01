<div class="card">
  <input type="hidden" value="<?= $trip_id ?>" id="current_trip_id">
  <div class="card-body">
    <h5 class="card-title text-center"><?= ucwords(strtolower($info_trip['origin'])) . ' - ' . ucwords(strtolower($info_trip['destination'])) ?></h5>
    <h6 class="card-title text-center"><?= $info_trip['date'] ?></h6>
    <div class="table-responsive">
      <table class="table table-hover table-bordered w-100" id="tickets-table">
        <thead class="text-center">
          <tr>
            <th rowspan="2">#</th>
            <th rowspan="2" class="table-success text-center">Bus</th>
            <!-- <th colspan="3" class="table-primary text-center">Viaje</th> -->
            <th colspan="6" class="table-warning text-center">Venta</th>
            <th rowspan="2">Acciones</th>
          </tr>
          <tr>
            <!-- <th class="table-primary">Origen</th>
            <th class="table-primary">Destino</th>
            <th class="table-primary">Salida</th> -->
            <th class="table-warning">Asiento</th>
            <th class="table-warning">Monto</th>
            <th class="table-warning">Usuario</th>
            <th class="table-warning">Fecha</th>
            <th class="table-warning">Cliente</th>
            <th class="table-warning">Estado</th>
          </tr>
        </thead>
        <?php foreach ($records as $key => $record) {
           if ($record['status'] == 'RESERVA') {
            $arraySeats = explode('-', $record['seat_number']);
           }
           ?>
          <tr>
            <td class="text-center fw-bold"><?= $record['client_id'] ?></td>
            <td><?= $record['bus_description'] ?></td>
            <!-- <td><?= strtoupper($record['origin']) ?></td>
            <td><?= strtoupper($record['destination']) . ' ' . (strlen($record['intermediate']) == 0 ? '' : '(' . strtoupper($record['intermediate']) . ')') ?></td>
            <td align="center"><?= (new DateTime($record['departure_date']))->format('d/m/Y') . " " . (new DateTime($record['departure_time']))->format('H:i') ?></td> -->
            <td class="text-center fw-bold text-primary"><?= strtoupper($record['seat_number']) ?></td>
            <td class="fw-bold text-success text-center"><?= $record['status'] == 'RESERVA' ? number_format($record['sold_price'] * count($arraySeats), 2) : number_format($record['sold_price'], 2) . " Bs" ?></td>
            <td align="center"><span class="badge text-bg-light"><?= strtoupper($record['username']) ?></span></td>
            <td align="center"><?= (new DateTime($record['sold_datetime']))->format('d/m/Y') . " " . (new DateTime($record['sold_datetime']))->format('H:i') ?></td>
            <td align="center"><?= $record['client'] ?></td>
            <td align="center"><span class="badge text-bg-<?=($record['status'] == 'VENDIDO' ? 'light' : 'danger')?>"><?= $record['status'] ?></span></td>
            <td class="text-center">
              <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#ticket-detail-modal" data-id="<?= $record['client_id'] ?>"><i class="fas fa-qrcode"></i></button>
              <?php if($record['status'] == 'VENDIDO') {?>
              <a class="btn btn-light me-2" href="../tickets/web_print.php?cid=<?= $record['client_id'] ?>" target="_blank" title="Ver Recibo"><i class="fas fa-file-pdf"></i></a>
              <?php } else { ?>
              <button 
                class="btn btn-warning me-2" 
                data-id="<?= $record['client_id'] ?>" 
                data-client="<?= $record['client'] ?>"
                data-sold-price="<?= $record['sold_price'] ?>"
                data-seat="<?= $record['seat_number'] ?>"
                data-price="<?= $record['price'] ?>"
                data-min-price="<?= $record['min_price'] ?>"
                title="Consolidar Venta"  
                data-bs-toggle="modal" 
                data-bs-target="#ticket-consolidate-modal">
                <i class="fas fa-money-bill-alt"></i>
              </button>
              <?php } ?>
              <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#ticket-delete-modal" data-id="<?= $record['client_id'] ?>"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

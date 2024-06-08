<div class="card">
  <div class="card-body">
    <table class="table table-striped" id="table_drivers" width="100%">
      <thead>
        <tr class="text-center">
          <th>ID</th>
          <th>Licencia</th>
          <th>Nombres y Apellidos</th>
          <th>Categor&iacute;a</th>
          <th>Descuento [%]</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($drivers as $driver) : ?>
          <tr>
            <td class="text-center"><?= $driver['id'] ?></td>
            <td class="text-center"><?= strtoupper($driver['license']) ?></td>
            <td class="text-center"><?= strtoupper($driver['fullname']) ?></td>
            <td class="text-center"><?= $driver['category'] ?></td>
            <td class="text-center"><?= number_format($driver['discount_rate'], 2) ?></td>
            <td class="text-center">
              <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#driver_delete" data-id="<?= $driver['id'] ?>"><i class="fa fa-solid fa-trash"></i> Dar Baja</button>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#driver-data-modal" data-id="<?= $driver['id'] ?>" data-action="update"><i class="fa fa-solid fa-pen"></i> Editar</button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
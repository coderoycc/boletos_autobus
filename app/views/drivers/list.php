  <table class="table table-striped" id="table_drivers" width="100%">
    <thead>
      <tr class="text-center">
        <th>ID</th>
        <th>Licencia</th>
        <th>Nombres y Apellidos</th>
        <th>Categor&iacute;a</th>
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
          <td class="text-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#driver_delete" data-id="<?= $driver['id'] ?>"><i class="fa fa-solid fa-trash"></i> Dar Baja</button>
              <button type="button" class="btn btn-outline-primary" onclick="updateView(<?= $driver['id'] ?>)"><i class="fa fa-solid fa-pen"></i> Editar</button>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
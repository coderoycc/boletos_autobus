  <table class="table table-striped" id="table_locations" width="100%">
    <thead>
      <tr class="text-center">
        <th>ID</th>
        <th>Nombre destino</th>
        <th>Acrónimo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($locations as $location) : ?>
        <tr>
          <td class="text-center"><?= $location['id'] ?></td>
          <td class="text-center"><?= strtoupper($location['location']) ?></td>
          <td class="text-center"><?= strtoupper($location['acronym']) ?></td>
          <td class="text-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-outline-danger"><i class="fa fa-solid fa-trash"></i> Eliminar</button>
              <button type="button" class="btn btn-outline-primary"><i class="fa fa-solid fa-pen"></i> Editar</button>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
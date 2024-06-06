  <table class="table table-striped" id="table_buses" width="100%">
    <thead>
      <tr class="text-center">
        <th>ID</th>
        <th>Placa</th>
        <th>Descripción</th>
        <th>Color</th>
        <th>Marca</th>
        <th>Creado en</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($buses as $bus) : ?>
        <tr>
          <td class="text-center"><?= $bus['id'] ?></td>
          <td class="text-center"><?= strtoupper($bus['placa']) ?></td>
          <td class="text-center"><?= strtoupper($bus['description']) ?></td>
          <td class="text-center"><?= $bus['color'] ?></td>
          <td class="text-center"><?= $bus['brand'] ?></td>
          <td class="text-center"><?= date('d/m/Y', strtotime($bus['created_at'])) ?></td>
          <td class="text-center">
            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
              <button type="button" class="btn btn-outline-danger"><i class="fa fa-solid fa-trash"></i> Dar Baja</button>
              <button type="button" class="btn btn-outline-primary"><i class="fa fa-solid fa-pen"></i> Editar</button>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
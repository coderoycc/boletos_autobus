<?php
require_once("../helpers/middlewares/web_auth.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Buses</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="../assets/seat-charts/jquery.seat-charts.css" />
  <script src="../assets/fontawesome/fontawesome6.min.js"></script>
  <script src="../assets/jquery/jquery.js"></script>
  <script src="../assets/jquery/jqueryToast.min.js"></script>
</head>

<body class="sb-nav-fixed">
  <?php include("../partials/header.php"); ?>
  <div id="layoutSidenav"> <!-- contenedor -->
    <?php include("../partials/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <div class="d-flex justify-content-between mt-4 flex-wrap">
            <h3>Buses</h3>
            <button class="btn btn-primary" onclick="add_new()"><i class="fa-lg fa-solid fa-map-location-dot"></i> Agregar nuevo bus</button>
          </div>
          <div class="row" id="data_buses"></div>
        </div>
      </main>
    </div>
  </div><!-- fin contenedor -->





  <!-- MODAL ELIMINAR -->
  <div class="modal fade" id="depa_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h1 class="modal-title text-white fs-5">¿ELIMINAR DESTINO?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <input type="hidden" id="id_location_delete">
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" onclick="delete_location()">Eliminar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- MODAL EDITAR -->
  <div class="modal fade" id="bus_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h1 class="modal-title text-white fs-5">NUEVO BUS</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal_content_edit">
          <form id="form_edit_bus" onsubmit="return false;">
            <div class="row">
              <div class="col-md-6 mb-2">
                <div class="form-floating">
                  <input type="text" class="form-control" name="placa" placeholder="Nro departamento">
                  <label for="placa">Placa</label>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="form-floating">
                  <input type="number" class="form-control" id="add_dep_bedrooms" name="bedrooms" placeholder="Habitaciones">
                  <label for="add_dep_bedrooms">Nro. de habitaciones</label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-info text-white" data-bs-dismiss="modal" onclick="update_department()">Actualizar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../js/options.js"></script>
  <script src="../js/functions.js"></script>
  <script src="../js/forms.js"></script>
  <script src="../js/services/buses.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="../assets/seat-charts/jquery.seat-charts.min.js"></script>
  <script src="./js/app.js"></script>
</body>

</html>
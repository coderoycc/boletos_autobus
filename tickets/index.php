<?php
  require_once("../helpers/middlewares/web_auth.php");
  date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Boletos</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css">
  <link rel="stylesheet" href="../assets/datatables/datatables.bootstrap5.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <script src="../assets/fontawesome/fontawesome6.min.js"></script>
  <script src="../assets/jquery/jquery.js"></script>
  <script src="../assets/jquery/jqueryToast.min.js"></script>
</head>

<body class="sb-nav-fixed">
  <?php 
    include("components/ticket_detail_modal.php"); 
    include("components/ticket_delete_modal.php"); 
    include("../partials/header.php"); 
  ?>
  <div id="layoutSidenav">
    <?php include("../partials/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <div class="d-flex justify-content-between my-4 flex-wrap">
            <h3 class="text-dark">BOLETOS</h3>
            <!-- <button class="btn text-white" style="--bs-btn-bg:var(--bs-blue);--btn-custom-bg-hover:var(--bs-complement);" type="button" data-bs-toggle="modal" data-bs-target="#modal_add_locker"><i class="fa-solid fa-circle-plus"></i> Nuevo casillero</button> -->
          </div>
          <div class="d-row mb-3">
            <form id="data-filter-form">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <label class="form-label fw-semibold">Nombre Cliente</label>
                      <div class="input-group mb-3">
                        <input class="form-control" id="client" name="client" type="text" placeholder="Ingrese el nombre del cliente" min="1">
                      </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="destination" class="form-label fw-semibold">Destino</label>
                      <select class="form-select" id="destination" name="destination" required></select>
                    </div>
                    <div class="col-md-2 mb-3">
                      <label for="initial-date" class="form-label fw-semibold">Fecha Inicio Salida</label>
                      <input class="form-control" id="initial-date" type="date" min="2024-05-31" name="initial_date" value="<?=(new DateTime())->modify('-1 day')->format('Y-m-d')?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                      <label for="final-date" class="form-label fw-semibold">Fecha Fin Salida</label>
                      <input class="form-control" id="final-date" type="date" min="2024-06-01" name="final_date" value="<?=(new DateTime())->format('Y-m-d')?>" required>
                    </div>
                    <div class="col-md-2 mb-3 align-self-end">
                      <button class="btn btn-outline-primary w-100" type="button" id="btn-search-filter"><i class="fas fa-filter me-2"></i>Filtrar</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="row">
            <div class="col-md-12" id="list_tickets"></div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="../js/options.js"></script>
  <script src="../js/functions.js"></script>
  <script src="../js/forms.js"></script>
  <script src="../js/services/tickets.js"></script>
  <script src="../js/services/locations.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="./js/app.js"></script>
</body>

</html>
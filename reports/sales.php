<?php
require_once("../helpers/middlewares/web_auth.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Reporte ventas</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <script src="../assets/fontawesome/fontawesome6.min.js"></script>
  <script src="../assets/jquery/jquery.js"></script>
  <script src="../assets/jquery/jqueryToast.min.js"></script>
</head>

<body class="sb-nav-fixed">
  <?php include("../partials/header.php"); ?>
  <div id="layoutSidenav">
    <?php include("../partials/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <div class="d-flex justify-content-between my-4 flex-wrap">
            <h3>Reporte de ventas</h3>
          </div>
          <div class="row">
            <div class="fs-5 text-secondary"> Filtros para generar el reporte PDF</div>
          </div>
          <form id="form_params_report">
            <div class="card">
              <div class="card-body">
                <div class="row mt-2">
                  <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary" for="start">Fecha de inicio</label>
                    <input class="form-control" id="start" type="date" name="start" placeholder="Fecha de inicio" value="<?= date('Y') . '-01-01' ?>" />
                  </div>
                  <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary" for="end">Fecha final</label>
                    <input class="form-control" id="end" type="date" name="end" placeholder="Fecha final" value="<?= date('Y-m-d') ?>" />
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary" for="locations">Destino</label>
                    <select class="form-select" id="locations" name="location_id"></select>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary" for="locations">Usuario vendedor</label>
                    <select class="form-select" id="users" name="user_id">
                    </select>
                  </div>
                  <div class="col-md-2 mt-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success" id="search"><i class="fa-lg fa-solid fa-file-pdf"></i> Generar reporte</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
    </div>
  </div>

  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="./js/app.js"></script>
</body>

</html>
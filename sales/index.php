<?php
  require_once("../helpers/middlewares/web_auth.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Ventas</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css" />
  <link rel="stylesheet" href="../css/custom.css" />
  <link rel="stylesheet" href="../assets/seat-charts/jquery.seat-charts.css" />
  <link rel="stylesheet" href="../assets/sweetalert2/sweetalert2.min.css" />
  <script src="../assets/fontawesome/fontawesome6.min.js"></script>
  <script src="../assets/jquery/jquery.js"></script>
  <script src="../assets/jquery/jqueryToast.min.js"></script>
  <script src="../assets/sweetalert2/sweetalert2.min.js"></script>
</head>

<body class="sb-nav-fixed">
  <?php 
    include("../partials/header.php");
    include("components/select_client_modal.php");
  ?>
  <div id="layoutSidenav"> <!-- contenedor -->
    <?php include("../partials/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <div class="row">
              <h1 class="mt-4 me-auto">Venta de Boleto</h1>
          </div>
          <div class="row align-items-center">
            <div class="col-md mb-3" style="max-width: 320px;">
              <button type="button" class="btn btn-outline-secondary w-100 mb-3" id="button-update-seats"><i class="fas fa-refresh me-2"></i>Actualizar Asientos</button>
              <img src="../assets/img/front_bus.png" class="img-fluid" width="300"/>
              <div id="seat-map">
                
              </div>
              <img src="../assets/img/rear_bus.png" class="img-fluid" width="300"/>
            </div>
            <div class="col-md mb-3">
              <div class="row">
                <div class="col-md-12">
                  <p class="fw-semibold text-secondary">Seleccione un asiento para la venta:</p>
                </div>
                <div class="col-md-12 mb-3" id="trip-data">
                  
                </div>
                <div class="col-md-12 mb-3">
                  <?php
                    include('components/sale_data_form.php');
                  ?>
                </div>
                <div class="col-md-12 mb-3 text-end">
                  <button type="button" class="btn btn-danger me-2 mb-2 mt-2"><i class="fas fa-times me-2"></i>Cancelar</button>
                  <button type="button" class="btn btn-success mb-2 mt-2" id="btn-create-sale"><i class="fas fa-save me-2"></i>Realizar Venta</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div><!-- fin contenedor -->

  <script src="../js/options.js"></script>
  <script src="../js/functions.js"></script>
  <script src="../js/forms.js"></script>
  <script src="../js/services/trips.js"></script>
  <script src="../js/services/seats.js"></script>
  <script src="../js/services/clients.js"></script>
  <script src="../js/services/tickets.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="../assets/seat-charts/jquery.seat-charts.min.js"></script>
  <script src="js/bus_seats.js"></script>
  <script src="js/app.js"></script>

</body>

</html>
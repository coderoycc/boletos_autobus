<?php
  require_once("../helpers/middlewares/web_auth.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Clientes</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css" />
  <link rel="stylesheet" href="../assets/datatables/datatables.bootstrap5.min.css">
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
  ?>
  <div id="layoutSidenav"> <!-- contenedor -->
    <?php include("../partials/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between mt-4 flex-wrap">
                <h3>Clientes</h3>
                <!--<button class="btn btn-success" onclick="add_new()"><i class="fa-lg fa-solid fa-user-plus"></i> Nuevo Cliente</button>-->
            </div>
            <div class="row mt-4" id="data-clients">

            </div>
        </div>
      </main>
    </div>
  </div><!-- fin contenedor -->

  <script src="../js/options.js"></script>
  <script src="../js/functions.js"></script>
  <script src="../js/forms.js"></script>
  <script src="../js/services/clients.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="../assets/seat-charts/jquery.seat-charts.min.js"></script>
  <script src="js/app.js"></script>

</body>
</html>
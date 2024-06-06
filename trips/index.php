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
  <title>Departamentos</title>
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
  <?php include("../partials/header.php"); ?>
  <div id="layoutSidenav">
    <?php include("../partials/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <div class="d-flex justify-content-between mt-4 flex-wrap">
            <h3>LISTA DE VIAJES</h3>
            <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#trip_add"><i class="fa-solid fa-circle-plus"></i> Nuevo viaje</button>
          </div>
          <div class="row mt-3" id="trips_content"></div>
        </div>
      </main>
    </div>
  </div>

  <!-- MODAL ELIMINAR -->
  <div class="modal fade" id="depa_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h1 class="modal-title text-white fs-5">¿ELIMINAR DEPARTAMENTO?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <input type="hidden" id="id_depa_delete">
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" onclick="delete_department()">Eliminar</button>
        </div>
      </div>
    </div>
  </div>

  <?php
    include('components/update_trip_modal.php');
    include('components/add_trip_modal.php');
  ?>

  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="./js/app.js"></script>
</body>

</html>
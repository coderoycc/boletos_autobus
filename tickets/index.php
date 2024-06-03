<?php
require_once("../helpers/middlewares/web_auth.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Casilleros</title>
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
            <h3 class="text-dark">BOLETOS</h3>
            <!-- <button class="btn text-white" style="--bs-btn-bg:var(--bs-blue);--btn-custom-bg-hover:var(--bs-complement);" type="button" data-bs-toggle="modal" data-bs-target="#modal_add_locker"><i class="fa-solid fa-circle-plus"></i> Nuevo casillero</button> -->
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="card shadow">
                <div class="card-body">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="search" type="text" placeholder="Enter your search">
                    <label for="search">Buscar ID</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example"></select>
                    <label for="search">Viajes a:</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-9" id="list_tickets"></div>
          </div>
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
<?php
  include('change_password_modal.php');
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
  <a class="navbar-brand ps-3" href="../"><i class=" fa-lg fa-solid fa-bus"></i> ADMIN <b>  BUSES</b></a>
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
  <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <!-- <div class="input-group">
      <input class="form-control" type="text" placeholder="Buscar" aria-label="Search for..." aria-describedby="btnNavbarSearch" />
      <button class="btn btn-secondary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
    </div> -->
  </form>
  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="#!">Usuario: <b><?= ucfirst($user->username) ?></b></a></li>
        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#change-password-modal">Cambiar Contraseña</a></li>
        <li>
          <hr class="dropdown-divider" />
        </li>
        <li><a class="dropdown-item" href="#!" id="idLogout">Cerrar sesión</a></li>
      </ul>
    </li>
  </ul>
</nav>
<?php
session_start();
date_default_timezone_set('America/La_Paz');
require_once 'config/accesos.php';
require_once 'config/database.php';
require_once '../helpers/resources/request.php';
require_once '../helpers/resources/response.php';
require_once './controllers/authController.php';
require_once './providers/authProvider.php';
require_once './providers/db_Provider.php';
$entidades = ['user', 'bus', 'location', 'trip', 'client', 'distribution', 'ticket'];
foreach ($entidades as $entidad) {
  require_once("models/" . $entidad . ".php");
  require_once("controllers/" . $entidad . "Controller.php");
}

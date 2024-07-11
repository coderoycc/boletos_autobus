<?php

use App\Models\Client;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Driver;
use App\Providers\DBWebProvider;

session_start();
date_default_timezone_set('America/La_Paz');
require_once(__DIR__ . '/../../app/config/database.php');
require_once(__DIR__ . '/../../app/providers/db_Provider.php');
require_once(__DIR__ . '/../../tcpdf/tcpdf.php');
require_once(__DIR__ . '/../../app/models/client.php');
require_once(__DIR__ . '/../../app/models/bus.php');
require_once(__DIR__ . '/../../app/models/trip.php');
require_once(__DIR__ . '/../../app/models/location.php');
require_once(__DIR__ . '/../../app/models/driver.php');

ob_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
$title1 = 'Reporte de Pasajeros';
$con = DBWebProvider::getSessionDataDB();

$trip_id = $_GET['trip_id'];
$clients = Client::getAllClientsByTrip($con, $trip_id);
$trip = new Trip($con, $trip_id);
$fechaTrip = $trip->departure_date;
$fechaTripFormato = date('d/m/Y', strtotime($fechaTrip));
$horaTrip = $trip->departure_time;
$horaTripFormato = date('H:i', strtotime($horaTrip));
$bus = new Bus($con, $trip->bus_id);
$location = new Location($con, $trip->location_id_dest);
$driver = new Driver($con, $trip->driver_id);
// $clients = array();

class MYPDF extends TCPDF
{
  public function Header()
  {
    $this->SetFont('helvetica', '', 8);
    $this->MultiCell(210, 2, "", 0, 'L', 0, 1, 10, 43, true);
  }
  public function Footer()
  {
  }
}

$width = 210;
$height = 5000;

$tam_fuente = 12;
$w = $width - 0;
$lineas = count($clients);
$aumentar = $lineas > 1 ? ($lineas - 1) * $tam_fuente : 0;
// $height = $height + $aumentar;

$pageLayout = array($width, $height);
$pdf = new MYPDF('P', 'pt', $pageLayout, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 15);

$pdf->SetAuthor('STIS');
$pdf->SetTitle($title1);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(5, 7, 5, false);
$pdf->SetFont('helvetica', '', 10);
$pdf->addPage();

$tabla = '
<table border="0" cellpadding="0.5">
<tr>
<td align="center" style="font-size: 12px;"><b>TRANS 25 DE DICIEMBRE</b></td>
</tr>
<tr>
<td align="center" style="font-size: 9px;">Uyuni-Oruro-Potosí-La Paz-Cochabamba</td>
</tr>
<tr>
<td align="center" style="border-bottom: 0.5px solid black;"><b>Celular: 67258945</b></td>
</tr>
</table>
<table border="0" cellpadding="0">
<tr>
<td colspan="10"><b>Cond.: </b>' . $driver->fullname . '</td>
</tr>
<tr>
<td colspan="10"><b>Nro. Licencia: </b>' . $driver->license . '</td>
</tr>
<tr>
<td colspan="10"><b>Bus Marca: </b>' . $bus->brand . '</td>
</tr>
<tr>
<td colspan="10"><b>Color: </b>' . $bus->color . '</td>
</tr>
<tr>
<td colspan="4"><b>Placa: </b>' . $bus->placa . '</td>
<td colspan="6"><b>Destino: </b>' . $location->location . '</td>
</tr>
<tr>
<td colspan="4"><b>H. Sal.: </b>' . $horaTripFormato . '</td>
<td colspan="6"><b>Fecha: </b>' . $fechaTripFormato . '</td>
</tr>
</table>
<table border="0" cellpadding="3">
<tr>
<td colspan="20" align="center" style="font-size: 12px; border-top: 0.5px solid black;"><b>Lista de pasajeros</b></td>
</tr>
</table>
<table border="0.5" cellpadding="1">
<tr>
<td colspan="1" align="center"><b>#</b></td>
<td colspan="9" align="center"><b>Nombre y Apellido</b></td>
<td colspan="5" align="center"><b>Carnet/PPT</b></td>
</tr>';
$nro  = 1;
foreach ($clients as $key => $value) {
  $nombre = ucwords($value['owner_name']);
  if ($nombre == '' || $nombre == null) {
    $nombre = ucfirst($value['name']) . ' ' . ucfirst($value['lastname']) . ' ' . ucfirst($value['mother_lastname']);
    if ($value['ci'] == '') {
      $cinit = $value['nit'];
    } else {
      $cinit = $value['ci'];
    }
  } else {
    $cinit = $value['owner_ci'];
  }
  $tabla .= '
    <tr>
    <td colspan="1" align="center">' . $nro . '</td>
    <td colspan="9" align="left">' . $nombre . '</td>
    <td colspan="5" align="left">' . $cinit . '</td>
    </tr>';
  $nro++;
}

$tabla .= '
</table>';

$pdf->writeHTML($tabla, true, 0, true, 0);
$pdf->Ln(4);
$pdf->lastPage();
$nom = "Reporte-" . $title1 . ".pdf";
ob_end_clean();
$pdf->output($nom, 'I');

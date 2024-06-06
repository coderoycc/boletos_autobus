<?php

use App\Models\Location;
use App\Models\Ticket;
use App\Models\User;
use App\Providers\DBWebProvider;

session_start();
date_default_timezone_set('America/La_Paz');
require_once(__DIR__ . '/../../app/config/accesos.php');
require_once(__DIR__ . '/../../app/config/database.php');
require_once(__DIR__ . '/../../app/providers/db_Provider.php');
require_once(__DIR__ . '/../../tcpdf/tcpdf.php');
require_once(__DIR__ . '/../../app/models/location.php');
require_once(__DIR__ . '/../../app/models/ticket.php');
require_once(__DIR__ . '/../../app/models/user.php');

ob_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
$title1 = 'Reporte de Ventas';
$inicio = $_GET['start'] == '' ? date('Y-m') . '-01' : $_GET['start'];
$final = $_GET['end'] == '' ? date('Y-m') . '-01' : $_GET['end'];
$id_location = $_GET['location_id'] ?? 0;
$user_id = $_GET['user_id'] ?? 0;
$con = DBWebProvider::getSessionDataDB();
$location_name = 'TODOS LOS DESTINOS';
if ($id_location > 0) {
  $location = new Location($con, $id_location);
  $location_name = strtoupper($location->location);
}
$user_name = "TODOS LOS USUARIOS";
if ($user_id > 0) {
  $user = new User($con, $user_id);
  $user_name = strtoupper($user->fullname);
}

$autor = "© STIS " . date('Y');
$style = array(
  'border' => false,
  'padding' => 0,
  'fgcolor' => array(0, 0, 0),
  'bgcolor' => false
);
$details = 'Desde ' . date('d/m/Y', strtotime($inicio)) . ' hasta ' . date('d/m/Y', strtotime($final));


class MYPDF extends TCPDF {
  public function Header() {
    $this->SetFont('helvetica', '', 8);
    $this->MultiCell(210, 2, "___________________________________________________________________________________________________", 0, 'L', 0, 1, 10, 48, true);
    $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $this->MultiCell(210, 2, "", 0, 'L', 0, 1, 155, 43, true);
  }
  public function Footer() {
    $this->SetY(-15);
    $this->SetFont('helvetica', 'I', 8);
    $this->Cell(0, 10, 'Pág. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
  }
}

$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, 15);

// if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
//   require_once(dirname(__FILE__) . '/lang/eng.php');
//   $pdf->setLanguageArray($l);
// }

$pdf->SetAuthor($autor);
$pdf->SetTitle($title1);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
$pdf->SetMargins(10, 10, 10, false);
$pdf->SetFont('times', '', 12);
$pdf->addPage();
// $linea1 = '_____________________________________________________________________________________________________________________';
$content = '';
$content .= '
  <h1 style="text-align:center;"> Reporte de ventas </h1>
';
$pdf->writeHTML($content, true, 0, true, 0);
$pdf->MultiCell(275, 2, $location_name, 0, 'C', 0, 1, '', '17', true);
$pdf->MultiCell(200, 2, $details, 0, 'L', 0, 1, '', '21', true);
$pdf->MultiCell(300, 5, 'Boletos vendidos por: ' . $user_name, 0, 'R', 0, 1, '-20', '21', true);
$pdf->SetFont('times', '', 11);
$tabla = '<table border="1" cellpadding="2">
    <thead>
      <tr>
        <th style="width:100px;padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">N&#186; Venta</th>
        <th style="width:60px;padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">N&#186;</th>
        <th style="width:160px;padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">Cliente</th>
        <th  style="padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">Origen</th>
        <th style="padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">Destino</th>
        <th style="padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">Fecha salida</th>
        <th style="padding: 8px; text-align: center; border: 1px solid #000; font-weight: bold;">Monto</th>
      </tr>
    </thead>
    <tbody>';
$preto = 0;
$lista_venta = Ticket::get_ticket_all($con, ['start' => $inicio, 'end' => $final, 'location_id' => $id_location, 'user_id' => $user_id]);
// var_dump($lista_venta);
// die();


if (sizeof($lista_venta) == 0) {
  $tabla .= '<tr>
      <td colspan="7" style="text-align: center; border: 1px solid #000; font-weight: bold;">No hay registros con los parametros enviados.</td>
    </tr>';
} else {
  $total = 0;
  $n = 1;
  foreach ($lista_venta as $ven) {
    set_time_limit(25);
    $tabla .= '
      <tr>
        <td style="text-align:center;width:100px;padding: 8px; border-top: 1px solid #000;">' . $ven['id'] . '</td>
        <td style="width:60px;text-align:center;padding: 8px; border-top: 1px solid #000;">' . $n . '</td>
        <td style="width:160px;padding: 8px; border-top: 1px solid #000;">' . strtoupper($ven['name'] . ' ' . $ven['lastname']) . '</td>
        <td style="text-align:center;padding: 8px; border-top: 1px solid #000;">' . strtoupper($ven['origen']) . '</td>
        <td style="text-align:center;padding: 8px; border-top: 1px solid #000;">' . strtoupper($ven['destino']) . '</td>
        <td style="text-align:center;padding: 8px; border-top: 1px solid #000;">' . date('d/m/Y', strtotime($ven['departure_date'])) . '</td>
        <td style="padding: 8px; border-top: 1px solid #000; text-align: rigth;">' . number_format($ven['monto_fin'], 2) . '</td>
      </tr>';
    $total += floatval($ven['monto_fin']);
  }
  $tabla .= '
      <tr>
        <td colspand="6" style="width:650px;text-align:right;font-size:110%;">Total Bs.: </td>
        <td style="text-align:right;width:119px;height:22px;font-weight:bold;font-size:120%;">' . number_format($total, 2) . '</td>
      </tr>';
}

$tabla .= '
    </tbody>
  </table>';

$pdf->writeHTML($tabla, true, 0, true, 0);
$pdf->Ln(4);
$pdf->lastPage();
$nom = "Reporte-" . $fecha . ".pdf";
ob_end_clean();
$pdf->output($nom, 'I');

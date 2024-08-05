<?php // COPIA DE G22
session_start();
require_once('../app/config/accesos.php');
require_once('../app/config/database.php');
require_once('../app/providers/db_Provider.php');
require_once('../tcpdf/tcpdf.php');
require_once('../app/models/trip.php');
require_once('../app/models/client.php');
require_once('../app/models/user.php');
require_once('../app/models/ticket.php');
require_once('../app/models/location.php');
require_once('./letras-numeros.php');

use App\Config\Accesos;
use App\Models\Client;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Trip;
use App\Models\Location;
use App\Providers\DBWebProvider;

if (!isset($_GET['cid'])) {
  echo '<h1 align="center">Parametro id necesario</h1>';
  die();
} else {

  /*ob_start();
  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 0);
  ini_set('log_errors', 1);*/

  $datos_emp = Accesos::enterprice_data();
  $con = DBWebProvider::getSessionDataDB();
  // print_r($datos_emp);
  // die();
  $subdominio = $datos_emp['name'];
  $nombre_suc = 'Sucursal Central';
  $ciudad = $datos_emp['location'];
  $routes = "Uyuni - Oruro - Potosí - La Paz - Cocha.";
  $companyName = "ASOCIACION DE TRANSPORTE LIBRE<br>25 DE DICIEMBRE";
  $phone = "67258945";
  $laneNumber = "3";
  $footerMessage = "El pasajero debe estar 30 minutos antes de la salida del bus, <b>NO SE ACEPTAN DEVOLUCIONES</b>.";
  // $ticket = new Ticket($con, $_GET['tid']);
  $ticket = Ticket::detail_by_client($con, $_GET['cid']);
  $ticket_seats = Ticket::tickets_by_client($con, $ticket['trip_id'], $ticket['client_id']);
  $cantidad = count($ticket_seats);
  $cadenaSeats = implode('-', $ticket_seats);

  if ($ticket['client_id'] == 0) {
    header('Location: ../');
    die();
  }

  $trip = new Trip($con, $ticket['trip_id']);
  $origen = $trip->origin();
  $destino = $trip->destination();
  $client = new Client($con, $ticket['client_id']);
  $user = new User($con, $ticket['sold_by']);
  $intermediate = new Location($con, ($ticket['intermediate_id'] == 0 ? null : $ticket['intermediate_id']));

  $width = 210;
  $height = 260;

  // Calculamos alto de pagina (unicamente por el campo detalle_envio) Es el unico que puede ser mas grande
  $tam_fuente = 8;
  $w = $width - 0; // width - margins-x
  // $lineas = contarLineas($envio->detalle_envio, $w, $tam_fuente) + contarLineas($envio->observacion_envio ?? '', $w, $tam_fuente);
  $lineas = 2;
  $aumentar = $lineas > 1 ? ($lineas - 1) * $tam_fuente : 0;
  $height = $height + $aumentar;


  $pageLayout = array($width, $height);
  $pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);

  $pdf->SetCreator('PDF_CREATOR');
  $pdf->SetAuthor('STIS - BOLIVIA');
  $pdf->SetTitle('Boleto de viaje');
  $pdf->setPrintHeader(false);
  $pdf->setPrintFooter(false);
  $pdf->SetMargins(0, 0, 0, false);
  $pdf->SetAutoPageBreak(true, 2);
  $pdf->SetFont('Helvetica', '', $tam_fuente);
  $pdf->addPage();

  // $baseUrl = "https://contaqr.com/buses";
  $baseUrl = "http://localhost/correspondencia";
  $codeqr = $baseUrl . "/qr/?rq=";

  $style = array(
    'border' => false,
    'padding' => 0,
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false
  );
  // $pdf->write2DBarcode($codeqr, 'QRCODE,Q', 145, 0, 60, 60, $style, 'N'); // 2 en vez de 20

  $costo = $cantidad * $ticket['sold_price'];
  $nit_ci = ($client->nit == '') ? $client->ci : $client->nit;
  $costo_literal = numtoletras($costo);
  // $porPagar = $envio->pagado ?? 'POR PAGAR';
  $dataCenter = "";
  $tabla = '<table border="0" cellpadding="0">
  <tr>
    <td colspan="500" align="center"><b style="font-size:120%;">' . $companyName . '</b></td>
  </tr>
  <tr>
    <td colspan="500" align="center">' . $routes . '</td>
  </tr>
  <tr>
    <td colspan="500" align="center" >Cel. ' . $phone . ' </td>
  </tr>
  <tr>
    <td colspan="500" align="center"><b style="font-size:120%;">Boleto #' . $ticket['client_id'] . '</b></td>
  </tr>
  <tr>
    <td colspan="500" align="center" style="font-size:120%;"><b>Asiento(s): ' . $cadenaSeats . '</b></td>
  </tr>
  <tr>
    <td colspan="500" align="center" style="border-bottom: 1px solid #000;font-size:100%;"><b>Carril: ' . $laneNumber . '</b></td>
  </tr>
  </table>';
  $dataCenter .= '<table border="0" cellpadding="0">
                    <tr>
                      <td colspan="380" align="center"><b style="font-size:120%;">Boleto #' . $ticket['client_id'] . '</b>
                      </td>
                    </tr>
                  </table>';
  $tabla .= '<table border="0" cellpadding="0">
              <tr><td colspan="500" style="font-size:50%;"></td></tr>
              <tr><td colspan="500"><b>Cliente: </b>' . strtoupper($client->name . ' ' . $client->lastname . ' ' . $client->mothers_lastname) . '</td></tr>
              <tr><td colspan="500"><b>NIT/CI/CEX: </b> ' . $nit_ci . '</td></tr>
              <tr><td colspan="500"><b>Fecha de emisión: </b>' . date('d/m/Y H:i', strtotime($ticket['sold_datetime'])) . '</td></tr>
              </table>';

  $tabla1 = '<table border="0" cellpadding="0">
              <tr>
                <td colspan="500" style="font-size:50%;border-top:1pt solid #6e6e6e"></td>
              </tr>
              <tr>
                <td colspan="500"><b>Lugar origen: </b> ' . strtoupper($origen->location) . '</td>
              </tr>
              <tr>
                <td colspan="500"><b>Lugar destino: </b> ' . strtoupper($destino->location) . ' ' . ($intermediate->id == 0 ? '' : '(' . strtoupper($intermediate->location) . ')') . '</td>
              </tr>
              <tr>
                <td colspan="250"><b>Fecha salida: </b>' . date('d/m/Y', strtotime($trip->departure_date)) . ' </td>
                <td colspan="250"><b>Hora salida: </b>' . date('H:i', strtotime($trip->departure_time)) . ' </td>
              </tr>
              <tr>
                <td colspan="250"><b>Asiento(s):</b> ' . $cadenaSeats . '</td>
                <td colspan="250"><b>Carril:</b> ' . $laneNumber . '</td>
              </tr>
              <tr>
                <td colspan="500"><b>Usuario: </b>' . strtoupper($user->username) . ' </td>
              </tr>
            </table>';
  $tabla .= $tabla1;
  $dataCenter .= $tabla1;

  $tabla2 = '<style>.border-bottom{border-bottom:1px dashed #000;}.text-85{font-size:85%;}</style>
    <table border="0" cellpadding="2">
    <tr><td colspan="500" style="font-size:40%;"></td></tr>
    <tr>
      <td align="center" colspan="70" class="border-bottom"><b>Cant</b></td>
      <td align="center" colspan="340" class="border-bottom"><b>Detalles</b></td>
      <td align="center" colspan="90" class="border-bottom"><b>Total</b></td>
    </tr>
    <tr>
      <td align="center" colspan="70" class="border-bottom">' . $cantidad . '</td>
      <td colspan="340" class="border-bottom">Boleto a ' . strtoupper($destino->location) . '</td>
      <td align="right" colspan="90" class="border-bottom">' . number_format($costo, 2) . '</td>
    </tr>
    <tr>
      <td colspan="500" onclick="Print()"><b>TOTAL</b></td>
    </tr>
    <tr>
      <td colspan="50"></td><td colspan="450">' . $costo_literal . '</td>
    </tr>';
  $tabla .= $tabla2 . '<tr>
      <td colspan="500">' . $footerMessage . '</td>
    </tr>
  </table>';
  $dataCenter .= $tabla2 . '</table>';

  $tabla .= '<table border="0" cellpadding="2">
              <tr><td colspan="500" style="font-size:40%;"></td></tr>
              <tr><td colspan="500" style="font-size:40%;"></td></tr>
            </table>';

  $tabla .= $dataCenter;

  // $tabla .= '<table border="0" cellpadding="0"><tr><td colspan="500"></td></tr><tr><td colspan="500"></td></tr><tr><td colspan="500"></td></tr><tr><td colspan="500"></td></tr><tr><td colspan="500"></td></tr>';
  // $tabla .= '<tr><td colspan="200" align="center" style="padding: 8px; text-align: left; border-bottom: 1px solid #000;"></td><td colspan="100"></td><td colspan="200" align="center" style="padding: 8px; text-align: left; border-bottom: 1px solid #000;"></td></tr>';
  // $tabla .= '<tr><td colspan="200" align="center" style="padding: 8px; text-align: center;">' . $subdominio . '</td><td colspan="100"></td><td colspan="200" align="center" style="padding: 8px; text-align: center;">Firma remitente</td></tr>';
  // $tabla .= '</table>';
  $pdf->WriteHTMLCell(0, 0, 0, 0, $tabla, 0, 0);

  // Form validation functions
  $js = <<<EOD
app.alert('qweqweqwe');
EOD;

  //$pdf->IncludeJS($js);
  // Add Javascript code
  $pdf->output('Venta-Boleto-' . $ticket['client_id'] . '.pdf', 'I');
}

function contarLineas($cadena, $anchoPagina, $tamanoFuente) {
  $caracteresPorLinea = ceil($anchoPagina / ($tamanoFuente * 0.75));

  $lineas = str_split($cadena, $caracteresPorLinea);

  // Contar el número de líneas
  $numeroLineas = count($lineas);

  return $numeroLineas;
}

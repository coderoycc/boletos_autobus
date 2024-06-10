<?php

use App\Models\Driver;
use App\Models\Location;
use App\Models\Ticket;
use App\Models\Trip;
use App\Providers\DBWebProvider;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    date_default_timezone_set('America/La_Paz');
    require_once(__DIR__ . '/../../tcpdf/tcpdf.php');
    require_once(__DIR__ . '/../../app/config/database.php');
    require_once(__DIR__ . '/../../app/providers/db_Provider.php');
    require_once(__DIR__ . '/../../app/models/trip.php');
    require_once(__DIR__ . '/../../app/models/driver.php');
    require_once(__DIR__ . '/../../app/models/location.php');
    require_once(__DIR__ . '/../../app/models/ticket.php');

    ob_start();
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 0);
    ini_set('log_erros', 1);
    $title1 = 'Reporte de Boleta de Liquidación';
    $trip_id = $_GET['trip_id'];
    $con = DBWebProvider::getSessionDataDB();
    $trip = new Trip($con, $trip_id);
    $fechaTrip = $trip->departure_date;
    $fechaTripFormato = date('d/m/Y', strtotime($fechaTrip));
    $driver = new Driver($con, $trip->driver_id);
    $locationOrigen = new Location($con, $trip->location_id_origin);
    $locationDestino = new Location($con, $trip->location_id_dest);
    $listaCountSum = Ticket::countSumTicket($con, $trip_id);
    // print_r($listaCountSum);

    class MYPDF extends TCPDF
    {
        public function Header()
        {
        }
        public function Footer()
        {
        }
    }
    $autor = 'STIS BOLIVIA';
    $width = 210;
    $height = 5000;
    $pageLayout = array($width, $height);
    $pdf = new MYPDF('P', 'pt', $pageLayout, true, 'UTF-8', false);
    $pdf->SetCreator($autor);
    $pdf->SetAutoPageBreak(false, 0);
    $pdf->SetAuthor($autor);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(5, 7, 5, false);
    $pdf->SetFont('times', '', 10);
    $pdf->addPage();

    $correspEncom = 0;
    $totalIngresos = 0;
    $ordenSalida = 0;
    $otrosDescuentos = 0;
    $totalEgresos = $ordenSalida + $otrosDescuentos;
    $tabla = '
    <table border="0" cellpadding="0.5">
    <tr>
    <td align="center" style="font-size: 12px;"><b>TRANS 25 DE DICIEMBRE</b></td>
    </tr>
    <tr>
    <td align="center" style="font-size: 9px;">Uyuni-Oruro-Potosí-La Paz-Cochabamba</td>
    </tr>
    <tr>
    <td align="center"><b>Celular: 67258945</b></td>
    </tr>
    </table>
    <table border="0" cellpadding="1">
    <tr>
    <td colspan="10" align="center" style="font-size: 11px; border-bottom: 0.5px solid black;"><b>BOLETA DE LIQUIDACION</b></td>
    </tr>
    </table>
    <table border="0" cellpadding="0.5">
    <tr>
    <td colspan="20"><b>Prop.: </b>' . $driver->fullname . '</td>
    </tr>
    <tr>
    <td colspan="20"><b>Nro. Viaje: </b>' . $trip->id . '</td>
    </tr>
    <tr>
    <td colspan="20"><b>Salida de: </b>' . $locationOrigen->location . '<b> a </b>' . $locationDestino->location . '</td>
    </tr>
    <tr>
    <td colspan="20" style="font-size: 9px; border-bottom: 0.5px solid black;"><b>Fecha: </b>' . $fechaTripFormato . '</td>
    </tr>
    <tr>
    <td colspan="20" style="font-size: 2px;"></td>
    </tr>
    </table>
    <table border="0" cellpadding="0.5">';
    $totalPorPasajeros = 0;
    foreach ($listaCountSum as $key => $value) {
        $totalPorPasajeros += $value['sumTickets'];
        $tabla .= '
        <tr>
        <td colspan="3" align="center">' . $value['countTickets'] . '</td>
        <td colspan="9"> pasajeros a ' . number_format($value['price'], 2) . '</td>
        <td colspan="2" align="right">Bs.</td>
        <td colspan="6" align="right">' . number_format($value['sumTickets'], 2) . '</td>
        </tr>';
    }
    $totalIngresos = $totalPorPasajeros + $correspEncom;
    $totalLiquidacion = $totalIngresos - $totalEgresos;
    $tabla .= '
    <tr>
    <td colspan="20" style="font-size: 2px;"></td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>Total por pasajeros Bs.</b></td>
    <td colspan="6" align="right" style="border-top: 0.3px dashed black;">' . number_format($totalPorPasajeros, 2) . '</td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>Corresp. y Encom. Bs.</b></td>
    <td colspan="6" align="right">' . number_format($correspEncom, 2) . '</td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>TOTAL INGRESOS Bs.</b></td>
    <td colspan="6" align="right" style="border-top: 0.3px solid black;">' . number_format($totalIngresos, 2) . '</td>
    </tr>
    </table>
    <table border="0" cellpadding="0.5">
    <tr>
    <td colspan="20" align="left"><b>Descuentos:</b></td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>Orden de salida Bs.</b></td>
    <td colspan="6" align="right">' . number_format($ordenSalida, 2) . '</td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>Otros descuentos Bs.</b></td>
    <td colspan="6" align="right">' . number_format($otrosDescuentos, 2) . '</td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>TOTAL EGRESOS Bs.</b></td>
    <td colspan="6" align="right" style="border-top: 0.3px solid black;">' . number_format($totalEgresos, 2) . '</td>
    </tr>
    </table>
    <table border="0" cellpadding="0.5">
    <tr>
    <td colspan="20" align="left"><b>Resúmen:</b></td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>Total Ingresos Bs.</b></td>
    <td colspan="6" align="right">' . number_format($totalIngresos, 2) . '</td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>Total Egresos Bs.</b></td>
    <td colspan="6" align="right">' . number_format($totalEgresos, 2) . '</td>
    </tr>
    <tr>
    <td colspan="14" align="right"><b>TOTAL LIQUIDACION Bs.</b></td>
    <td colspan="6" align="right" style="border-top: 0.3px solid black;"><b>' . number_format($totalLiquidacion, 2) . '</b></td>
    </tr>
    </table>
    <table border="0">
    <tr>
    <td colspan="10" style="font-size: 40px;"></td>
    </tr>
    <tr>
    <td colspan="1"></td>
    <td colspan="8" align="center" style="border-top: 0.3px solid black;">Recibí conforme</td>
    <td colspan="1"></td>
    </tr>
    <tr>
    <td colspan="10" style="font-size: 35px;"></td>
    </tr>
    <tr>
    <td colspan="1"></td>
    <td colspan="8" align="center" style="border-top: 0.3px solid black;">Entregué conforme</td>
    <td colspan="1"></td>
    </tr>
    </table>';

    $pdf->writeHTML($tabla, true, 0, true, 0);
    $pdf->lastPage();
    $nom = "Reporte-" . $title1 . ".pdf";
    ob_end_clean();
    $pdf->output($nom, 'I');
} else {
    echo 'No tiene acceso a esta parte del sistema.';
}

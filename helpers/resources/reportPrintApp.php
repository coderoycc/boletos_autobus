<?php

namespace Helpers\Resources;

require_once('formatLine.php');
require_once('configurations.php');

class ReportPrintApp {

    static function ticketSaleDetail($ticket, $client, $trip, $origin, $destination, $bus){
        $created_at = date_create_from_format('Y-m-d H:i:s.v', $ticket->created_at);
        $departure = date_create_from_format('Y-m-d H:i:s', $trip->departure_date." ".$trip->departure_time);
        $lines = array(
            new FormatLine(Configurations::$MODE_FONT_SIZE, Configurations::$FONT_SIZE_0),
            new FormatLine(Configurations::$MODE_ALIGN_TEXT, Configurations::$ALIGN_CENTER),
            new FormatLine(Configurations::$MODE_TEXT, '25 DE DICIEMBRE'),
            new FormatLine(Configurations::$MODE_TEXT, '(2)22222'),
            new FormatLine(Configurations::$MODE_TEXT, 'UYUNI - POTOSI'),
            new FormatLine(Configurations::$MODE_TEXT, Configurations::$LINE_FORMAT_0),
            new FormatLine(Configurations::$MODE_TEXT, "N° VENTA #".$ticket->id),
            new FormatLine(Configurations::$MODE_TEXT, Configurations::$LINE_FORMAT_0),
            new FormatLine(Configurations::$MODE_ALIGN_TEXT, Configurations::$ALIGN_LEFT),
            new FormatLine(Configurations::$MODE_TEXT, "Cliente: ".strtoupper($client->lastname != '' ? $client->lastname : $client->mothers_lastname)),
            new FormatLine(Configurations::$MODE_TEXT, "NIT/CI/CEX: ".($client->ci != '' ? $client->ci : $client->nit)),
            new FormatLine(Configurations::$MODE_TEXT, "Fecha: ".date_format($created_at, 'd/m/Y')."    Hora: ".date_format($created_at, 'H:i')),
            new FormatLine(Configurations::$MODE_TEXT, Configurations::$LINE_FORMAT_0),
            new FormatLine(Configurations::$MODE_TEXT, "Nro. Asiento: ".$ticket->seat_number),
            new FormatLine(Configurations::$MODE_TEXT, "Origen: ".strtoupper($origin->location)),
            new FormatLine(Configurations::$MODE_TEXT, "Destino: ".strtoupper($destination->location)),
            new FormatLine(Configurations::$MODE_TEXT, "\n"),
            new FormatLine(Configurations::$MODE_TEXT, "Partida: ".date_format($departure, 'd/m/Y')."  Hora: ".date_format($created_at, 'H:i')),
            new FormatLine(Configurations::$MODE_TEXT, Configurations::$LINE_FORMAT_1),
            new FormatLine(Configurations::$MODE_TEXT, "1 Asiento a ".strtoupper($destination->location)),
            new FormatLine(Configurations::$MODE_TEXT, Configurations::$LINE_FORMAT_1),
            new FormatLine(Configurations::$MODE_TEXT, "\n"),
            new FormatLine(Configurations::$MODE_ALIGN_TEXT, Configurations::$ALIGN_RIGHT),
            new FormatLine(Configurations::$MODE_TEXT, "PRECIO TOTAL.- ".Configurations::convertStringToMoney($ticket->price, true)),
            new FormatLine(Configurations::$MODE_TEXT, "\n"),
            new FormatLine(Configurations::$MODE_ALIGN_TEXT, Configurations::$ALIGN_LEFT),
            new FormatLine(Configurations::$MODE_TEXT, Configurations::numberToLetters($ticket->price)),
        );

        return $lines;

    }

}

?>
<?php

namespace App\Controllers;

use App\Models\Ticket;
use App\Models\Client;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Bus;
use App\Providers\DBWebProvider;
use Helpers\Resources\Request;
use Helpers\Resources\Response;

class TicketController {

    public function create($data){
        $con = DBWebProvider::getSessionDataDB();
        if($con){
            $ticket = new Ticket($con);
            $ticket->seat_number = $data['seat_number'];
            $ticket->trip_id = $data['trip_id'];
            $ticket->client_id = $data['client_id'];
            $ticket->created_at = date('Y-m-d H:i:s');
            $ticket->sold_by = json_decode($_SESSION['user'])->id;
            $res = $ticket->save();
            if($res){
                Response::success_json('Venta registrada correctamente.', ['ticket' => $ticket]);
            }else{
                Response::error_json(['message' => 'No se pudo registrar la venta.'], 200);
            }
        }else{
            Response::error_json(['message' => 'Error conexion instancia'], 200);
        }
    }

    public function PrintTicketApp($data){
        if (!Request::required(['ticket_id'], $data)) {
            Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);
        }

        $con = DBWebProvider::getSessionDataDB();
        $ticket = new Ticket($con, $data['ticket_id']);
        if($ticket->id == 0){
            $client = new Client($con, $ticket->client_id);
            $trip = new Trip($con, $ticket->trip_id);
            $origin = new Location($con, $trip->location_id_origin);
            $destination = new Location($con, $trip->location_id_dest);
            $bus = new Bus($con, $trip->bus_id);
            

        }else{
            Response::error_json(['message' => 'No se encontro los datos de la venta.'], 200);
        }
    }

}
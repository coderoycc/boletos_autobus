<?php

namespace App\Controllers;

use App\Models\Ticket;
use App\Providers\DBWebProvider;
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

}
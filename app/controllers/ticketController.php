<?php

namespace App\Controllers;

use App\Models\Ticket;
use App\Models\Client;
use App\Models\User;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Bus;
use App\Providers\DBWebProvider;
use Helpers\Resources\Request;
use Helpers\Resources\Response;
use Helpers\Resources\Render;
use Helpers\Resources\ReportPrintApp;

class TicketController {

  public function create($data) {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $client = new Client($con);
      $client->name = $data['name'];
      $client->lastname = $data['lastname'];
      $client->ci = $data['ci'];
      $client->nit = $data['nit'];
      $client->is_minor = isset($data['is_minor']) ? 1 : 0;
      $client->user_id = json_decode($_SESSION['user'])->id;
      $client->created_at = date('Y-m-d H:i:s');
      $res = $client->save();
      if ($res) {
        $ticket = new Ticket($con);
        $ticket->seat_number = $data['seat_number'];
        $ticket->trip_id = $data['trip_id'];
        $ticket->client_id = $client->id;
        $ticket->created_at = date('Y-m-d H:i:s');
        $ticket->sold_by = json_decode($_SESSION['user'])->id;
        $ticket->price = $data['price'];
        $ticket->intermediate_id = $data['intermediate_id'];
        $ticket->status = $data['status'];
        $res = $ticket->save();
        if ($res) {
          Response::success_json('Venta registrada correctamente.', ['ticket' => $ticket]);
        } else {
          Response::error_json(['message' => 'No se pudo registrar la venta.'], 200);
        }
      } else {
        Response::error_json(['message' => 'No se pudo registrar el cliente.'], 200);
      }
    } else {
      Response::error_json(['message' => 'Error conexion instancia'], 200);
    }
  }

  public function reservedSeats($query) {
    if (!Request::required(['trip_id'], $query))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $trip_id = $query['trip_id'];
    $con = DBWebProvider::getSessionDataDB();
    Response::success_json('Lista de asientos reservados actualizada correctamente.', [
      'reserved' => Ticket::reservedSeats($con, $trip_id),
    ]);
  }

  public function PrintTicketApp($data) {
    if (!Request::required(['ticket_id', 'db_name'], $data))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    DBWebProvider::start_session_app(['dbname' => $data['db_name']]);
    $con = DBWebProvider::getSessionDataDB();
    $ticket = new Ticket($con, $data['ticket_id']);
    if ($ticket->id > 0) {
      $client = new Client($con, $ticket->client_id);
      $trip = new Trip($con, $ticket->trip_id);
      $origin = new Location($con, $trip->location_id_origin);
      $destination = new Location($con, $trip->location_id_dest);
      $bus = new Bus($con, $trip->bus_id);
      Response::success_json('Datos de la venta cargados correctamente.', [
        'document' => ReportPrintApp::ticketSaleDetail($ticket, $client, $trip, $origin, $destination, $bus),
      ]);
      print_r(ReportPrintApp::ticketSaleDetail([]));
    } else {
      Response::error_json(['message' => 'No se encontro los datos de la venta.'], 200);
    }
  }

  public function TicketDetail($query) {
    $query['db_name'] = 'boletos_25_diciembre';
    $db_name = $query['db_name'];
    $ticket_id = $query['ticket_id'];
    DBWebProvider::start_session_app(['dbname' => $db_name]);
    $con = DBWebProvider::getSessionDataDB();
    $ticket = new Ticket($con, $ticket_id);
    if ($ticket->id > 0) {
      $client = new Client($con, $ticket->client_id);
      $trip = new Trip($con, $ticket->trip_id);
      $origin = new Location($con, $trip->location_id_origin);
      $destination = new Location($con, $trip->location_id_dest);
      $bus = new Bus($con, $trip->bus_id);
      Render::view('tickets/card_detail_view', [
        'ticket' => $ticket,
        'client' => $client,
        'trip' => $trip,
        'origin' => $origin,
        'destination' => $destination,
        'bus' => $bus,
      ]);
    } else {
      Render::view('error_html', ['message' => 'Datos de la venta no encontrados, contacte con el administrador', 'message_details' => '404 Ticket not found']);
    }
  }

  public function getAllTicketsView($data) {
    $con = DBWebProvider::getSessionDataDB();
    if (!isset($data['trip_id']) || $data['trip_id'] == '0' || $data['trip_id'] == 0) {
      $last_trip = Trip::get_first_trip_today($con);
      $data['trip_id'] = $last_trip->id;
    }
    $records = Ticket::index($con, $data);
    Render::view('tickets/ticket_list_view', [
      'records' => $records,
      'trip_id' => $data['trip_id'],
    ]);
  }

  public function deleteSoldTicket($data) {
    if (!Request::required(['password', 'ticket_id'], $data))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $con = DBWebProvider::getSessionDataDB();
    $id = $data['ticket_id'];
    $password = hash('sha256', $data['password']);
    $userId = json_decode($_SESSION['user'])->id;

    $user = new User($con, $userId);

    if ($password == $user->password) {
      $ticket = new Ticket($con, $id);
      $res = $ticket->delete();
      if ($res) {
        Response::success_json('Venta eliminada correctamente.', []);
      } else {
        Response::error_json(['message' => 'No se pudo eliminar la venta.'], 200);
      }
    } else {
      Response::error_json(['message' => 'Contraseña ingresada incorrecta.'], 200);
    }
  }

  public function consolidateSale($data){
    if (!Request::required(['price', 'ticket_id'], $data))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $ticket_id = $data['ticket_id'];
      $price = floatval($data['price']);
      $ticket = new Ticket($con, $ticket_id);
      if($ticket->id > 0){
        $ticket->price += $price;
        $ticket->status = "VENDIDO";
        $ticket->created_at = date('Y-m-d H:i:s');
        $response = $ticket->update();
        if($response){
          Response::success_json('Venta consolidada correctamente.', [
            'ticket' => $ticket,
          ]);
        }else{
          Response::error_json(['message' => 'No se pudo consolidar la venta.'], 200);  
        }
      }else{
        Response::error_json(['message' => 'No se encontro el boleto.'], 200);
      }
    }else{
      Response::error_json(['message' => 'No se pudo conectar a la BD.'], 200);
    }
  }
}

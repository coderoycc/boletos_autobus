<?php

namespace App\Controllers;

use App\Models\Ticket;
use App\Models\Client;
use App\Models\User;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Bus;
use App\Providers\DBWebProvider;
use DateTime;
use Helpers\Resources\Request;
use Helpers\Resources\Response;
use Helpers\Resources\Render;
use Helpers\Resources\ReportPrintApp;

class TicketController
{

  public function create($data)
  {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $arrTickets = $data['seat_number'];
      if (Ticket::are_sold($con, $data['trip_id'], $data['seat_number']))
        Response::error_json(['message' => 'Los asientos ya fueron vendidos'], 200);

      $client = new Client($con);
      $client->name = $data['name'];
      $client->lastname = $data['lastname'];
      $client->ci = $data['ci'];
      $client->nit = $data['nit'];
      $client->is_minor = isset($data['is_minor']) ? 1 : 0;
      $client->user_id = json_decode($_SESSION['user'])->id;
      $client->created_at = date('Y-m-d\TH:i:s');
      $res = $client->save();
      if ($res) {
        $names = $data['name_passenger'];
        $cis = $data['ci_passenger'];
        $minor = $data['minor'] ?? [];
        $n = count($arrTickets);
        $ok = 0;
        foreach ($arrTickets as $s_num) {
          $ticket = new Ticket($con);
          $ticket->seat_number = $s_num;
          $ticket->trip_id = $data['trip_id'];
          $ticket->client_id = $client->id;
          $ticket->created_at = date('Y-m-d\TH:i:s');
          $ticket->sold_by = $client->user_id;
          $ticket->price = $data['price'];
          $ticket->intermediate_id = $data['intermediate_id'];
          $ticket->status = $data['status'];
          $ticket->is_minor = isset($minor[$s_num]) ? 1 : 0;
          $ticket->owner_name = isset($names[$s_num]) ? $names[$s_num] : '';
          $ticket->owner_ci = isset($cis[$s_num]) ? $cis[$s_num] : '';
          $res = $ticket->save();
          if ($res)
            $ok++;
        }
        if ($ok == $n) {
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

  public function reservedSeats($query)
  {
    if (!Request::required(['trip_id'], $query))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $trip_id = $query['trip_id'];
    $con = DBWebProvider::getSessionDataDB();
    Response::success_json('Lista de asientos reservados actualizada correctamente.', [
      'reserved' => Ticket::reservedSeats($con, $trip_id),
    ]);
  }

  public function PrintTicketApp($data)
  {
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
    } else {
      Response::error_json(['message' => 'No se encontro los datos de la venta.'], 200);
    }
  }

  public function TicketDetail($query)
  {
    $query['db_name'] = 'boletos_25_diciembre';
    $db_name = $query['db_name'];
    $client_id = $query['client_id'];
    DBWebProvider::start_session_app(['dbname' => $db_name]);
    $con = DBWebProvider::getSessionDataDB();
    // $ticket = new Ticket($con, $client_id);
    $ticket = Ticket::detail_by_client($con, $client_id);
    if (count($ticket) > 0) {
      $client = new Client($con, $ticket['client_id']);
      $trip = new Trip($con, $ticket['trip_id']);
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

  public function getAllTicketsView($data)
  {
    $con = DBWebProvider::getSessionDataDB();
    $info_trip_array = array('origin' => '', 'destination' => '', 'date' => '', 'time' => '');
    if (!isset($data['trip_id']) || $data['trip_id'] == '0' || $data['trip_id'] == 0) {
      $last_trip = Trip::get_first_trip_today($con);
      $data['trip_id'] = $last_trip->id;
    } else {
      $current_trip = new Trip($con, $data['trip_id']);
      $origin_trip = $current_trip->origin();
      $destination_trip = $current_trip->destination();
      $info_trip_array['origin'] = $origin_trip->location;
      $info_trip_array['destination'] = $destination_trip->location;
      $dateTime = new DateTime($current_trip->departure_date . ' ' . $current_trip->departure_time);
      $info_trip_array['date'] = $dateTime->format('d/m/Y H:i');
      // $info_trip_array['time'] = $current_trip->departure_time;
    }
    $records = Ticket::index($con, $data);
    Render::view('tickets/ticket_list_view', [
      'records' => $records,
      'trip_id' => $data['trip_id'],
      'info_trip' => $info_trip_array
    ]);
  }

  public function deleteSoldTicket($data)
  {
    if (!Request::required(['password', 'id'], $data))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $con = DBWebProvider::getSessionDataDB();
    $id = $data['id'];
    $password = hash('sha256', $data['password']);
    $userId = json_decode($_SESSION['user'])->id;

    $user = new User($con, $userId);

    if ($password == $user->password) {
      // $ticket = new Ticket($con, $id);
      // $res = $ticket->delete();
      $res = Ticket::delete_by_client($con, $id);
      if ($res) {
        Response::success_json('Venta eliminada correctamente.', []);
      } else {
        Response::error_json(['message' => 'No se pudo eliminar la venta.'], 200);
      }
    } else {
      Response::error_json(['message' => 'Contraseña ingresada incorrecta.'], 200);
    }
  }

  public function consolidateSale($data)
  {
    if (!Request::required(['price', 'client_id'], $data))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $client_id = $data['client_id'];
      $price = floatval($data['price']);
      // $ticket = new Ticket($con, $client_id);
      $ticket = Ticket::detail_by_client($con, $client_id);
      // print_r($ticket);
      if ($client_id > 0) {
        $newPrice = $price + $ticket['sold_price'];
        $status = "VENDIDO";
        $created_at = date('Y-m-d\TH:i:s');
        // echo $created_at;
        // $response = $ticket->update();
        $response = Ticket::update_by_client($con, $client_id, $newPrice, $status, $created_at);
        // print_r($response);
        // echo $response;
        if ($response) {
          Response::success_json('Venta consolidada correctamente.', [
            'ticket' => $ticket,
          ]);
        } else {
          Response::error_json(['message' => 'No se pudo consolidar la venta.'], 200);
        }
      } else {
        Response::error_json(['message' => 'No se encontró el cliente.'], 200);
      }
    } else {
      Response::error_json(['message' => 'No se pudo conectar a la BD.'], 200);
    }
  }
  public function get_data_ticket($query)
  {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $ticket = Ticket::ticket_by_seat($con, $query['trip_id'], $query['seat_number']);
      Response::success_json('Datos de la venta cargados correctamente.', [$ticket], 200);
    } else {
      Response::error_json(['message' => 'Error conexion instancia'], 200);
    }
  }
}

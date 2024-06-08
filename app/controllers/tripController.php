<?php

namespace App\Controllers;

use App\Models\Bus;
use App\Models\Location;
use App\Models\Trip;
use App\Models\Distribution;
use App\Models\Ticket;
use App\Models\Driver;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Response;

class TripController {

  public function create($data, $files = null) {
    $con = DBWebProvider::getSessionDataDB();
    $trip = new Trip($con);
    $trip->bus_id = $data['bus'];
    $trip->departure_date = $data['departure_date'];
    $trip->departure_time = $data['departure_time'];
    $trip->location_id_origin = $data['origin'];
    $trip->location_id_dest = $data['destination'];
    $trip->min_price = floatval($data['min_price']);
    $trip->price = floatval($data['price']);
    $trip->driver_id = intval($data['driver_id']);
    if ($trip->save()) {
      Response::success_json('Agregado correctamente', [], 200);
    } else {
      Response::error_json(['message' => 'NO se agrego'], 200);
    }
  }
  public function get_table($query) {
    $con = DBWebProvider::getSessionDataDB();
    $date = $query['date'] ?? date('Y-m-d');
    $trips = Trip::all($con, $query);
    Render::view('trips/list', ['trips' => $trips, 'date' => $date]);
  }
  public function content_edit($query) {
    $con = DBWebProvider::getSessionDataDB();
    $trip = new Trip($con, $query['id']);
    if ($trip->id) {
      $buses = Bus::all($con);
      $drivers = Driver::all($con);
      $locations = Location::all($con);
      Render::view('trips/modal_edit_content', ['trip' => $trip, 'locations' => $locations, 'buses' => $buses, 'drivers' => $drivers]);
    } else {
      Render::view('error_html', ['message' => 'Parametro ID no encontrado', 'message_details' => '404 Trip not found']);
    }
  }
  public function update($data) {
    $con = DBWebProvider::getSessionDataDB();
    $trip = new Trip($con, $data['trip_id']);
    $trip->bus_id = $data['bus'];
    $trip->departure_date = $data['departure_date'];
    $trip->departure_time = $data['departure_time'];
    $trip->location_id_origin = $data['origin'];
    $trip->location_id_dest = $data['destination'];
    $trip->min_price = floatval($data['min_price']);
    $trip->price = floatval($data['price']);
    $trip->driver_id = intval($data['driver_id']);
    if ($trip->save()) {
      Response::success_json('Actualizado correctamente', [], 200);
    } else {
      Response::error_json(['message' => 'NO se actualizo'], 200);
    }
  }
  public function cardData($query) {
    $con = DBWebProvider::getSessionDataDB();
    $trip = new Trip($con, $query['id']);
    if ($trip->id) {
      $bus = new Bus($con, $trip->bus_id);
      $origin = new Location($con, $trip->location_id_origin);
      $destination = new Location($con, $trip->location_id_dest);
      Render::view('trips/card_data', ['trip' => $trip, 'bus' => $bus, 'origin' => $origin, 'destination' => $destination]);
    } else {
      Render::view('error_html', ['message' => 'Ocurrió un error, contacte con el administrador', 'message_details' => '404 Trip not found']);
    }
  }

  public function getDataDistribution($query) {
    $con = DBWebProvider::getSessionDataDB();
    $trip = new Trip($con, $query['trip_id']);

    if ($trip->id) {
      $bus = new Bus($con, $trip->bus_id);
      if ($bus->id) {
        $distributions = Distribution::getDistributionData($con, $bus->distribution_id);
        $reserved = Ticket::reservedSeats($con, $trip->id);
        Response::success_json('Consulta realizada correctamente', [
          'floor1' => $distributions['1'],
          'floor2' => $distributions['2'],
          'reserved' => $reserved,
          'trip' => $trip,
        ], 200);
      } else {
        Response::error_json(['message' => 'El id de bus es incorrecto.'], 200);
      }
    } else {
      Response::error_json(['message' => 'El id de viaje es incorrecto.'], 200);
    }
  }
  public function get_all($query) {
    $con = DBWebProvider::getSessionDataDB();
    $date = $query['date'] ?? date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
    $time = '00:00:00';
    $filters = ['date' => $date, 'time' => $time];
    $trips = Trip::all($con, $filters);
    Response::success_json('Consulta realizada correctamente', $trips, 200);
  }
}

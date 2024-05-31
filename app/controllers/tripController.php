<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Providers\DBWebProvider;
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
    if ($trip->save()) {
      Response::success_json('Agregado correctamente', [], 200);
    } else {
      Response::error_json(['message' => 'NO se agrego'], 200);
    }
  }
}

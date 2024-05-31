<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Location;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Response;

class LocationController {
  public function create($data, $files = null) {
    $conection = DBWebProvider::getSessionDataDB();
    $location = new Location($conection);
    $location->location = $data['location'];
    $location->acronym = $data['acronym'] ?? '';
    if ($location->save())
      Response::success_json('Agregado correctamente', [], 200);
    else
      Response::error_json(['message' => 'Error'], 200);
  }
  public function all($query) {
    $conection = DBWebProvider::getSessionDataDB();
    $locations = Location::all($conection);
    Response::success_json('Agregado correctamente', $locations, 200);
  }
  public function list($query) {
    $conection = DBWebProvider::getSessionDataDB();
    $locations = Location::all($conection);
    Render::view('locations/list', ['locations' => $locations]);
  }
}

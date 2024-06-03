<?php

namespace App\Controllers;

use App\Models\Bus;
use App\Models\Distribution;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Response;

class BusController {
  public function card_add_new($query){
    $connect = DBWebProvider::getSessionDataDB();
    $distros = Distribution::distros($connect);
    Render::view('buses/new_bus', ['distros' => $distros]);
  }
  public function list_all($query) {
    $conection = DBWebProvider::getSessionDataDB();
    $buses = Bus::all($conection);
    Response::success_json('OK', $buses);
  }
  public function all($query) {
    $conecion = DBWebProvider::getSessionDataDB();
    $buses = Bus::all($conecion);
    Render::view('buses/list', ['buses' => $buses]);
  }
}

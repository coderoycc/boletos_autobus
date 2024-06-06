<?php

namespace App\Controllers;

use App\Models\Bus;
use App\Models\Distribution;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Response;

class BusController {

  public function create($data){
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
        $bus = new Bus($con);
        $bus->placa = $data['plate'];
        $bus->description = $data['description'];
        $bus->distribution_id = $data['distribution_id'];
        $bus->created_at = date('Y-m-d H:i:s');
        $bus->color = $data['color'];
        $bus->brand = $data['brand'];
        $bus->driver = $data['driver'];
        $bus->license = $data['license'];
        $res = $bus->save();
        if($res){
            Response::success_json('Bus creado correctamente.', ['bus' => $bus]);
        }else{
            Response::error_json(['message' => 'Error al crear el cliente.'], 200);
        }
    }else{
        Response::error_json(['message' => 'Error conexion instancia.'], 200);
    }
  }

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

<?php

namespace App\Controllers;

use App\Models\Driver;
use App\Models\Distribution;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Response;
use Helpers\Resources\Request;

class DriverController {

  public function create($data) {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $driver = new Driver($con);
      $driver->category = $data['category'];
      $driver->fullname = $data['fullname'];
      $driver->license = $data['license'];
      $driver->state = 'ACTIVO';
      $res = $driver->save();
      if ($res) {
        Response::success_json('Conductor creado correctamente.', ['driver' => $driver]);
      } else {
        Response::error_json(['message' => 'Error al crear el cliente.'], 200);
      }
    } else {
      Response::error_json(['message' => 'Error conexion instancia.'], 200);
    }
  }

  public function update($data) {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $driver = new Driver($con, intval($data['id']));
      $driver->category = $data['category'];
      $driver->fullname = $data['fullname'];
      $driver->license = $data['license'];
      $res = $driver->update();
      if ($res) {
        Response::success_json('Chofer actualizado correctamente.', []);
      } else {
        Response::error_json(['message' => 'Error al crear el cliente.'], 200);
      }
    } else {
      Response::error_json(['message' => 'Error conexion instancia.'], 200);
    }
  }

  public function card_add_new($query) {
    $connect = DBWebProvider::getSessionDataDB();
    $distros = Distribution::distros($connect);
    Render::view('drivers/new_driver', ['distros' => $distros]);
  }
  public function card_update($data) {
    if (!Request::required(['driver_id'], $data))
      Response::error_json(['message' => 'Faltan parámetros necesarios.'], 200);

    $connect = DBWebProvider::getSessionDataDB();
    $driverId = $data['driver_id'];
    $driver = new Driver($connect, $driverId);
    $distros = Distribution::distros($connect);
    Render::view('drivers/update_driver', [
      'driver' => $driver,
      'distros' => $distros,
    ]);
  }
  public function list_all($query) {
    $conection = DBWebProvider::getSessionDataDB();
    $drivers = Driver::all($conection);
    Response::success_json('OK', $drivers);
  }
  public function all($query) {
    $conecion = DBWebProvider::getSessionDataDB();
    $drivers = Driver::all($conecion);
    Render::view('drivers/list', ['drivers' => $drivers]);
  }
  public function down_driver($data) {
    $conection = DBWebProvider::getSessionDataDB();
    $driver = new Driver($conection, intval($data['driver_id']));
    $driver->state = 'INACTIVO';
    $res = $driver->update();
    if ($res) {
      Response::success_json('Conductor actualizado correctamente.', []);
    } else {
      Response::error_json(['message' => 'Error al actualizar el conductor.'], 200);
    }
  }
}

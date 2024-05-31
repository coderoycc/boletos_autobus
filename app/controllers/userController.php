<?php

namespace App\Controllers;

use App\Config\Accesos;
use App\Config\Database;
use App\Models\User;
use App\Providers\DBAppProvider;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Request;
use Helpers\Resources\Response;

class UserController {
  public function create($data, $files) {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $usuario = new User($con);
      $usuario->username = $data['usuario'];
      $usuario->password = hash('sha256', $data['usuario']);
      // print_r($usuario);
      $usuario->role = $data['rol'];
      $usuario->fullname = $data['nombre'];
      $usuario->status = 1;
      $res = $usuario->save();
      if ($res) {
        unset($usuario->password);
        Response::success_json('Usuario creado correctamente', ['user' => $usuario]);
      } else {
        Response::error_json(['message' => 'Error al crear el usuario'], 200);
      }
    } else {
      Response::error_json(['message' => 'Error conexion instancia'], 200);
    }
  }
  public function changepass($data, $files = null) {
    $id = $data['idUsuario'];
    $pass = $data['pass'];
    $new = $data['newPass'];
    $usuario = new User($id);
    if ($usuario->id == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'No existe el usuario | idUsuario incorrecto'));
    } else if ($usuario->password != hash('sha256', $pass)) {
      echo json_encode(array('status' => 'error', 'message' => 'La contraseña anterior es incorrecta'));
    } else {
      $res = $usuario->newPass($new);
      if ($res > 0) {
        echo json_encode(array('status' => 'success', 'message' => 'La contraseña fue cambiada exitosamente'));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Ocurrió un error al cambiar la contraseña, intenta más tarde'));
      }
    }
  }

  // public function changecolor($data, $files = null) {
  //   $id = $data['idUsuario'];
  //   $color = $data['color'];
  //   $user = new Usuario($id);
  //   if ($user->idUsuario != 0 && $color != '') {
  //     $user->color = $color;
  //     $res = $user->save();
  //     if ($res > 0) {
  //       echo json_encode(['status' => 'success', 'message' => 'Cambio correcto']);
  //     } else {
  //       echo json_encode(['status' => 'error', 'message' => 'Error inesperado']);
  //     }
  //   } else {
  //     echo json_encode(['status' => 'error', 'message' => 'No de puede guardar, datos faltantes']);
  //   }
  // }

  public function delete($data) /* WEB */ {
    $id = $data['idUsuario'];
    $con = DBWebProvider::getSessionDataDB();
    $usuario = new User($con, $id);
    if ($usuario->id == 0) {
      Response::error_json(['message' => 'Usuario no encontrado'], 200);
    } else {
      $res = $usuario->delete();
      if ($res > 0) {
        Response::success_json('El usuario fue eliminado exitosamente', []);
      } else
        Response::error_json(['message' => 'No se elimino el usuario'], 200);
    }
  }
  public function update($data) {
    $con = DBWebProvider::getSessionDataDB();
    if ($con == null)
      Response::error_json(['message' => 'Error conexion instancia'], 200);
    $idUsuario = $data['idUsuario'];
    $user = $data['usuario'];
    $rol = $data['rol'];
    $usuario = new User($con, $idUsuario);
    if ($usuario->id == 0) {
      Response::error_json(['message' => 'No existe el usuario | idUsuario incorrecto'], 200);
    } else {
      $usuario->username = $user;
      $usuario->role = $rol;
      $usuario->fullname = $data['nombre'];
      $res = $usuario->save();
      if ($res > 0) {
        Response::success_json('Acutalizado correctamente', [], 200);
      } else {
        Response::error_json(['message' => 'Error al actualizar el usuario'], 200);
      }
    }
  }
  public function resetPass($data)/* WEB */ {
    $id = $data['idUsuario'];
    $con = DBWebProvider::getSessionDataDB();
    $usuario = new User($con, $id);
    if ($usuario->id == 0) {
      Response::error_json(['message' => 'Usuario no existente'], 200);
    } else {
      if ($usuario->resetPass()) {
        Response::success_json('Contraseña actualizada', []);
      } else
        Response::error_json(['message' => 'No se realizó el cambio la contraseña'], 200);
    }
  }
  public function get_admins($data) {
    $con = DBWebProvider::getSessionDataDB();
    if ($con) {
      $admins = User::all_users($con);
      Response::success_json('Administradores', $admins);
    } else Response::error_json(['message' => 'Sin conexión a la base de datos'], 200);
  }
}

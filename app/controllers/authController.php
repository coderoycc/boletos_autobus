<?php

namespace App\Controllers;

use App\Config\Accesos;
use App\Providers\DBWebProvider;
use Helpers\Resources\Response;
use App\Providers\AuthProvider;
use Helpers\Resources\Request;

class AuthController {
  public function login_web($data, $files = null) {
    if (!Request::required(['user', 'password'], $data))
      Response::error_json(['message' => 'Datos incompletos'], 401);

    //$enterpriceData['dbname'] = 'boletos';
    $enterpriceData['dbname'] = 'boletos_25_diciembre';
    // var_dump($condominioData);

    // $condominioData = Accesos::getCondominio($data['pin']);
    // if (!empty($condominioData)) {
    $auth = new AuthProvider(null, $enterpriceData['dbname']);
    $res_auth = $auth->auth_web($data['user'], $data['password']);
    if ($res_auth['user']) {
      DBWebProvider::start_session($res_auth['user'], $enterpriceData);
      Response::success_json('Login Correcto', []);
    } else {
      Response::error_json(['message' => 'Credenciales incorrectas'], 401);
    }
    // } else {
    //   Response::error_json(['message' => 'Pin incorrecto'], 401);
    // }
  }
  public function logout() {
    try {
      DBWebProvider::session_end();
      Response::success_json('Logout Correcto', []);
    } catch (\Throwable $th) {
      var_dump($th);
    }
    Response::error_json(['message' => 'Logout incorrecto'], 401);
  }
}

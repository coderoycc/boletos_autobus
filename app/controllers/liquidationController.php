<?php

namespace App\Controllers;

use App\Models\Liquidation;
use App\Providers\DBWebProvider;
use Helpers\Resources\Request;
use Helpers\Resources\Response;

class LiquidationController {
  public function create($body, $files = null) {
    $con = DBWebProvider::getSessionDataDB();

    if (!Request::required(['trip_id', 'other_amount'], $body))
      Response::error_json(['message' => 'Parametros faltantes'], 200);
    $liquidation = new Liquidation($con);
    $liquidation->trip_id = intval($body['trip_id']);
    $liquidation->discount = floatval($body['other_amount']);
    $liquidation->observation = $body['other_concept'] ?? '';
    $liquidation->observation_discount = floatval($body['other_concept_amount']);
    $liquidation->correspondence = floatval($body['correspondence']);
    if ($liquidation->save() > 0) {
      Response::success_json('Liquidacion registrada', [$liquidation]);
    } else {
      Response::error_json(['message' => 'Error al registrar la liquidacion'], 200);
    }
  }
}

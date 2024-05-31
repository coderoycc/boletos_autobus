<?php

namespace App\Models;

use PDO;

class Bus {
  public static function all($con) {
    try {
      $sql = "SELECT * FROM buses;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return [];
  }
}

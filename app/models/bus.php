<?php

namespace App\Models;

use PDO;

class Bus {
  private $con;
  public int $id;
  public string $placa;
  public string $description;
  public int $distribution_id;
  public string $created_at;
  public function __construct($con = null, $id = null) {
    $this->objectNull();
    if ($con != null) {
      $this->con = $con;
      if ($id != null) {
        $sql = "SELECT * FROM buses WHERE id=:id";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row)
          $this->load($row);
      }
    }
  }
  public function objectNull() {
    $this->id = 0;
    $this->placa = "";
    $this->description = "";
    $this->distribution_id = 0;
    $this->created_at = "";
  }
  public function load($row) {
    $this->id = $row['id'];
    $this->placa = $row['placa'];
    $this->description = $row['description'];
    $this->distribution_id = $row['distribution_id'];
    $this->created_at = $row['created_at'];
  }
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

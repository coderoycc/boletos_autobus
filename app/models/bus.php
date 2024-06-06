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
  public string $color;
  public string $brand;
  public string $driver;
  public string $license;

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
    $this->color = "";
    $this->brand = "";
    $this->driver = "";
    $this->license = "";
  }
  public function load($row) {
    $this->id = $row['id'];
    $this->placa = $row['placa'];
    $this->description = $row['description'];
    $this->distribution_id = $row['distribution_id'];
    $this->created_at = $row['created_at'];
    $this->color = $row['color'];
    $this->brand = $row['brand'];
    $this->driver = $row['driver'];
    $this->license = $row['license'];
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

  public function save(){
    if ($this->con == null){ return -1; }
    try{
        $resp = 0;
        $this->con->beginTransaction();
        $sql = "INSERT 
                INTO buses (placa, description, distribution_id, created_at, color, brand, driver, license) 
                VALUES (:plate, :description, :distribution_id, :created_at, :color, :brand, :driver, :license);";
        $params = [
            'plate' => $this->placa,
            'description' => $this->description,
            'distribution_id' => $this->distribution_id,
            'created_at' => $this->created_at,
            'color' => $this->color,
            'brand' => $this->brand,
            'driver' => $this->driver,
            'license' => $this->license,
        ];
        $stmt = $this->con->prepare($sql);
        $res = $stmt->execute($params);
        if ($res) {
            $this->con->commit();
            $this->id = $this->con->lastInsertId();
            $resp = $this->id;
        } else {
            $resp = -1;
            $this->con->rollBack();
        }
        return $resp;
    }catch(\Throwable $th){
        //print_r($th);
        $this->con->rollBack();
        return -1;
    }
}

public function update(){
  if ($this->con == null){ return -1; }

  $this->con->beginTransaction();
  try{
      $resp = 0;
      $sql = "UPDATE buses 
              SET placa = :plate, description = :description, distribution_id = :distribution_id,
                  created_at = :created_at, color = :color, brand = :brand, driver = :driver, license = :license
              WHERE id = :id;";
      $params = [
          'plate' => $this->placa,
          'description' => $this->description,
          'distribution_id' => $this->distribution_id,
          'created_at' => $this->created_at,
          'color' => $this->color,
          'brand' => $this->brand,
          'driver' => $this->driver,
          'license' => $this->license,
          'id' => $this->id,
      ];
      $stmt = $this->con->prepare($sql);
      $res = $stmt->execute($params);
      if ($res) {
          $this->con->commit();
          $resp = $this->id;
      } else {
          $resp = -1;
          $this->con->rollBack();
      }
      return $resp;
  }catch(\Throwable $th){
      //print_r($th);
      $this->con->rollBack();
      return -1;
  }
}

}

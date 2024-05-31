<?php

namespace App\Models;

use PDO;

class Trip {
  private $con;
  public int $id;
  public string $departure_time;
  public string $departure_date;
  public int $bus_id;
  public int $location_id_origin;
  public int $location_id_dest;
  public float $min_price;
  public float $price;
  public function __construct($con = null, $id = null) {
    $this->objectNull();
    if ($con != null) {
      $this->con = $con;
      if ($id != null) {
        $sql = "SELECT * FROM trips WHERE id = $id;";
        $result = $this->con->query($sql);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        if ($row) $this->load($row);
      }
    }
  }
  public function objectNull() {
    $this->id = 0;
    $this->departure_time = '';
    $this->departure_date = '';
    $this->bus_id = 0;
    $this->location_id_origin = 0;
    $this->location_id_dest = 0;
    $this->min_price = 0;
    $this->price = 0;
  }
  public function load($row) {
    $this->id = $row['id'];
    $this->departure_time = $row['departure_time'];
    $this->departure_date = $row['departure_date'];
    $this->bus_id = $row['bus_id'];
    $this->location_id_origin = $row['location_id_origin'];
    $this->location_id_dest = $row['location_id_dest'];
    $this->min_price = $row['min_price'] ?? 0;
    $this->price = $row['price'] ?? 0;
  }
  public function save() {
    try {
      if ($this->id == 0) {
        $sql = "INSERT INTO trips(departure_date, departure_time, bus_id, location_id_origin, min_price, price, location_id_dest) VALUES(?,?,?,?,?,?,?);";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->departure_date, $this->departure_time, $this->bus_id, $this->location_id_origin, $this->min_price, $this->price, $this->location_id_dest]);
        $this->id = $this->con->lastInsertId();
      } else {
        $sql = "UPDATE trips SET departure_date = ?, departure_time = ?, bus_id = ?, location_id_origin = ?, min_price = ?, price = ?, location_id_dest = ? WHERE id = ?;";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->departure_date, $this->departure_time, $this->bus_id, $this->location_id_origin, $this->min_price, $this->price, $this->location_id_dest, $this->id]);
      }
      return true;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return false;
  }
}

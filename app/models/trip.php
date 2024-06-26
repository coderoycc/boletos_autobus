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
  public int $driver_id;

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
    $this->driver_id = 0;
  }
  public function origin(): Location {
    return new Location($this->con, $this->location_id_origin);
  }
  public function destination(): Location {
    return new Location($this->con, $this->location_id_dest);
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
    $this->driver_id = $row['driver_id'] ?? 0;
  }
  public function save() {
    try {
      if ($this->id == 0) {
        $sql = "INSERT INTO trips(departure_date, departure_time, bus_id, location_id_origin, min_price, price, location_id_dest, driver_id) 
                VALUES( ? , ? , ? , ? , ? , ? , ? , ? );";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->departure_date, $this->departure_time, $this->bus_id, $this->location_id_origin, $this->min_price, $this->price, $this->location_id_dest, $this->driver_id]);
        $this->id = $this->con->lastInsertId();
      } else {
        $sql = "UPDATE trips SET departure_date = ?, departure_time = ?, bus_id = ?, location_id_origin = ?, min_price = ?, price = ?, location_id_dest = ? , driver_id = ? WHERE id = ?;";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->departure_date, $this->departure_time, $this->bus_id, $this->location_id_origin, $this->min_price, $this->price, $this->location_id_dest, $this->driver_id, $this->id]);
      }
      return true;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return false;
  }
  public static function all($con, $filters) {
    try {
      $exact = $filters['exact'] ?? false;

      $date = $filters['date'] ?? date('Y-m-d');
      $time = $filters['time'] ?? date('H:i:s');
      // Sumar 30 minutos a la hora actual
      $newTime = date('H:i:s', strtotime('-30 minutes', strtotime($time)));

      $filter = $exact
        ? "a.departure_date = '$date'"
        : "CONCAT(CONVERT(varchar,a.departure_date,23),' ',CONVERT(varchar,a.departure_time,24)) >= '$date $newTime'";

      $sql = "SELECT a.*, b.location as origen, c.location as destino, d.placa, e.fullname as conductor,
                CONCAT(CONVERT(varchar,a.departure_date,23),' ',CONVERT(varchar,a.departure_time,24)), f.id as liq_id
              FROM trips a 
              INNER JOIN locations b ON a.location_id_origin = b.id
              INNER JOIN locations c ON a.location_id_dest = c.id
              INNER JOIN buses d ON a.bus_id = d.id
              INNER JOIN drivers e ON a.driver_id = e.id
              LEFT JOIN liquidations f ON a.id = f.trip_id
              WHERE $filter;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
      //print_r($th);
    }
    return [];
  }
  public static function get_first_trip_today($con): Trip {
    $trip = new Trip($con);
    try {
      $date = date('Y-m-d');
      $time = date('H:i:s');
      $sql = "SELECT TOP 1 * FROM trips WHERE departure_date >= '$date' AND departure_time >= '$time';";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row) $trip->load($row);
    } catch (\Throwable $th) {
      //throw $th;
    }
    return $trip;
  }
}

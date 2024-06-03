<?php

namespace App\Models;

use PDO;

class Ticket {

  private $con;

  public int $id;
  public int $seat_number;
  public int $trip_id;
  public int $client_id;
  public String $created_at;
  public int $sold_by;
  public float $price;

  public function __construct($db = null, $id = null) {
    $this->objectNull();
    if ($db) {
      $this->con = $db;
      if ($id != null) {
        $sql = "SELECT * 
                        FROM tickets WHERE id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if ($row) {
          $this->load($row);
        }
      }
    }
  }

  public function load($row) {
    $this->id = $row['id'];
    $this->seat_number = $row['seat_number'];
    $this->trip_id = $row['trip_id'];
    $this->client_id = $row['client_id'];
    $this->created_at = $row['created_at'];
    $this->sold_by = $row['sold_by'];
    $this->price = $row['price'];
  }

  public function objectNull() {
    $this->id = 0;
    $this->seat_number = 0;
    $this->trip_id = 0;
    $this->client_id = 0;
    $this->created_at = '';
    $this->sold_by = 0;
    $this->price = 0.0;
  }

  public static function reservedSeats($con, $trip_id) {
    try {
      $sql = "SELECT t.seat_number
                    FROM tickets t
                    WHERE t.trip_id = :trip_id;";
      $stmt = $con->prepare($sql);
      $stmt->execute([
        'trip_id' => $trip_id
      ]);
      $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $res = [];
      foreach ($seats as $seat) {
        array_push($res, $seat['seat_number']);
      }
      return $res;
    } catch (\Throwable $th) {
      //var_dump($th);
    }
    return [];
  }

  public function save() {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "INSERT 
                    INTO tickets (seat_number, trip_id, client_id, created_at, sold_by, price) 
                    VALUES (:seat_number, :trip_id, :client_id, :created_at, :sold_by, :price);";
      $params = [
        'seat_number' => $this->seat_number, 'trip_id' => $this->trip_id,
        'client_id' => $this->client_id, 'created_at' => $this->created_at,
        'sold_by' => $this->sold_by, 'price' => $this->price
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
    } catch (\Throwable $th) {
      //print_r($th);
      $this->con->rollBack();
      return -1;
    }
  }

  public static function get_ticket_all($con, $query) {
    try {
      $sql = "SELECT a.id as id_ticket, a.price as monto_fin, a.seat_number, b.*, c.location as origen, d.location as destino, e.ci, e.nit, e.name, e.lastname, e.mothers_lastname 
        FROM tickets a 
        INNER JOIN trips b ON a.trip_id = b.id
        INNER JOIN locations c ON b.location_id_origin = c.id 
        INNER JOIN locations d ON b.location_id_dest = d.id
        INNER JOIN clients e ON a.client_id = e.id WHERE";
      $start = $query['start'] ?? date('Y-m') . '-01';
      $end = $query['end'] ?? date('Y-m-d');
      $q_loca_id = isset($query['location_id']) && $query['location_id'] != 0 ? ' d.id = ' . $query['location_id'] . ' AND' : '';
      $where = "$q_loca_id b.departure_date BETWEEN '$start' AND '$end'";
      $order = " ORDER BY b.departure_date ASC, a.seat_number ASC;";
      $stmt = $con->prepare($sql . $where . $order);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }
}

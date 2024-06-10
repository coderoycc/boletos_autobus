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
  public int $intermediate_id;
  public String $status;

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
    $this->intermediate_id = $row['intermediate_id'] ?? 0;
    $this->status = $row['status'] ?? '';
  }

  public function objectNull() {
    $this->id = 0;
    $this->seat_number = 0;
    $this->trip_id = 0;
    $this->client_id = 0;
    $this->created_at = '';
    $this->sold_by = 0;
    $this->price = 0.0;
    $this->intermediate_id = 0;
    $this->status = '';
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
                    INTO tickets (seat_number, trip_id, client_id, created_at, sold_by, price, intermediate_id, status)
                    VALUES (:seat_number, :trip_id, :client_id, :created_at, :sold_by, :price, :intermediate_id, :status);";
      $params = [
        'seat_number' => $this->seat_number, 'trip_id' => $this->trip_id,
        'client_id' => $this->client_id, 'created_at' => $this->created_at,
        'sold_by' => $this->sold_by, 'price' => $this->price,
        'intermediate_id' => $this->intermediate_id, 'status' => $this->status
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

  public function update() {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "UPDATE tickets
              SET seat_number = :seat_number, trip_id = :trip_id, client_id = :client_id, 
                  created_at = :created_at, sold_by = :sold_by, price = :price, 
                  intermediate_id = :intermediate_id, status = :status
              WHERE id = :id;";
      $params = [
        'seat_number' => $this->seat_number, 'trip_id' => $this->trip_id,
        'client_id' => $this->client_id, 'created_at' => $this->created_at,
        'sold_by' => $this->sold_by, 'price' => $this->price,
        'intermediate_id' => $this->intermediate_id, 'status' => $this->status,
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
    } catch (\Throwable $th) {
      //print_r($th);
      $this->con->rollBack();
      return -1;
    }
  }

  public function delete() {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "DELETE 
              FROM tickets  
              WHERE id = :id;";
      $params = [
        'id' => $this->id,
      ];
      $stmt = $this->con->prepare($sql);
      $res = $stmt->execute($params);
      if ($res) {
        $this->con->commit();
        $resp = 1;
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
      $q_user_id = isset($query['user_id']) && $query['user_id'] != 0 ? ' AND a.sold_by = ' . $query['user_id'] : '';
      $where = "$q_loca_id b.departure_date BETWEEN '$start' AND '$end'" . $q_user_id;
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

  public static function index($con, $data) {
    try {
      $client = $data['client'];
      $trip_id = $data['trip_id'] ?? 0;
      $filterByDestination = intval($trip_id) > 0 ? "AND t.trip_id = $trip_id" : "";
      $sql = "SELECT t.id as ticket, t.price as sold_price, t.seat_number, t.created_at as sold_datetime,
                      b.description as bus_description, b.placa,
                      tr.*, o.location as origin, d.location as destination, 
                      e.ci, e.nit, CONCAT(e.name, ' ', e.lastname, ' ', e.mothers_lastname) AS client,
                      i.location AS intermediate,
                      u.username, t.status, tr.price, tr.min_price
              FROM tickets t
              LEFT JOIN trips tr ON t.trip_id = tr.id
              LEFT JOIN locations o ON tr.location_id_origin = o.id 
              LEFT JOIN locations d ON tr.location_id_dest = d.id
              LEFT JOIN locations i ON t.intermediate_id = i.id
              LEFT JOIN clients e ON t.client_id = e.id
              LEFT JOIN buses b ON b.id = tr.bus_id
              LEFT JOIN users u ON u.id = t.sold_by
              WHERE CONCAT(e.name, ' ', e.lastname, ' ', e.mothers_lastname) LIKE '%$client%'
                    $filterByDestination
              ORDER BY t.id DESC;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }

  public static function countSumTicket($con, $trip_id) {
    try {
      $sql = "SELECT price, COUNT(price) as countTickets, SUM(price) as sumTickets  FROM tickets WHERE trip_id = '$trip_id' GROUP BY price;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
    }
  }
}

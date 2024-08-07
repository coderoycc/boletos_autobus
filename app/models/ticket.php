<?php

namespace App\Models;

use PDO;

class Ticket
{

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
  public string $owner_name;
  public int $is_minor;
  public string $owner_ci;

  public function __construct($db = null, $id = null)
  {
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

  public function load($row)
  {
    $this->id = $row['id'];
    $this->seat_number = $row['seat_number'];
    $this->trip_id = $row['trip_id'];
    $this->client_id = $row['client_id'];
    $this->created_at = $row['created_at'];
    $this->sold_by = $row['sold_by'];
    $this->price = $row['price'];
    $this->intermediate_id = $row['intermediate_id'] ?? 0;
    $this->status = $row['status'] ?? '';
    $this->owner_name = $row['owner_name'] ?? '';
    $this->is_minor = $row['is_minor'] ?? 0;
    $this->owner_ci = $row['owner_ci'] ?? '';
  }

  public function objectNull()
  {
    $this->id = 0;
    $this->seat_number = 0;
    $this->trip_id = 0;
    $this->client_id = 0;
    $this->created_at = '';
    $this->sold_by = 0;
    $this->price = 0.0;
    $this->intermediate_id = 0;
    $this->status = '';
    $this->owner_name = '';
    $this->is_minor = 0;
    $this->owner_ci = '';
  }

  public static function reservedSeats($con, $trip_id, $status = 'VENDIDO')
  {
    try {
      $sql = "SELECT t.seat_number
                    FROM tickets t
                    WHERE t.trip_id = :trip_id AND status = '$status';";
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

  public function save()
  {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "INSERT 
                    INTO tickets (seat_number, trip_id, client_id, created_at, sold_by, price, intermediate_id, status, owner_name, is_minor, owner_ci)
                    VALUES (:seat_number, :trip_id, :client_id, :created_at, :sold_by, :price, :intermediate_id, :status, :owner_name, :is_minor, :owner_ci);";
      $params = [
        'seat_number' => $this->seat_number, 'trip_id' => $this->trip_id,
        'client_id' => $this->client_id, 'created_at' => $this->created_at,
        'sold_by' => $this->sold_by, 'price' => $this->price,
        'intermediate_id' => $this->intermediate_id, 'status' => $this->status,
        'owner_name' => $this->owner_name, 'is_minor' => $this->is_minor, 'owner_ci' => $this->owner_ci
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

  public function update()
  {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "UPDATE tickets
              SET seat_number = :seat_number, trip_id = :trip_id, client_id = :client_id, 
                  created_at = :created_at, sold_by = :sold_by, price = :price, 
                  intermediate_id = :intermediate_id, status = :status, owner_name = :owner_name, is_minor = :is_minor
              WHERE id = :id;";
      $params = [
        'seat_number' => $this->seat_number, 'trip_id' => $this->trip_id,
        'client_id' => $this->client_id, 'created_at' => $this->created_at,
        'sold_by' => $this->sold_by, 'price' => $this->price,
        'intermediate_id' => $this->intermediate_id, 'status' => $this->status,
        'owner_name' => $this->owner_name, 'is_minor' => $this->is_minor,
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

  public function delete()
  {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "DELETE 
              FROM tickets  
              WHERE client_id = :id;";
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

  public static function detail_by_client($con, $client_id)
  {
    try {
      $resp = 0;
      $con->beginTransaction();
      $sql = "SELECT temporal.*, asientos.seat_number FROM ( SELECT DISTINCT t.client_id, t.price as sold_price, FORMAT(t.created_at, 'yyyy-MM-dd HH:mm') as sold_datetime, t.trip_id, t.status, t.sold_by, t.intermediate_id FROM tickets t WHERE t.client_id = '$client_id') as temporal LEFT JOIN ( SELECT client_id, STRING_AGG(seat_number, '-') as seat_number from tickets GROUP BY client_id) as asientos ON temporal.client_id = asientos.client_id ORDER BY temporal.client_id DESC;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }

  public static function update_by_client($con, $client_id, $newPrice, $status, $created_at)
  {
    if ($con == null) {
      return -1;
    }
    try {
      $price = number_format($newPrice, 2);
      $resp = 0;
      $isTransactionActive = $con->inTransaction();
      if (!$isTransactionActive) {
        $con->beginTransaction();
      }
      // $con->beginTransaction();
      $sql = "UPDATE tickets SET price = '$price', status = '$status', created_at = '$created_at' WHERE client_id = '$client_id';";
      $stmt = $con->prepare($sql);
      $res = $stmt->execute();
      if ($res) {
        $con->commit();
        $resp = 1;
      } else {
        $resp = -1;
        $con->rollBack();
      }
      return $resp;
    } catch (\Throwable $th) {
      $con->rollBack();
      return $th;
    }
  }

  public static function delete_by_client($con, $client_id)
  {
    try {
      $resp = 0;
      $con->beginTransaction();
      $sql = "DELETE 
              FROM tickets  
              WHERE client_id = :id;";
      $params = [
        'id' => $client_id,
      ];
      $stmt = $con->prepare($sql);
      $res = $stmt->execute($params);
      if ($res) {
        $con->commit();
        $resp = 1;
      } else {
        $resp = -1;
        $con->rollBack();
      }
      return $resp;
    } catch (\Throwable $th) {
      //print_r($th);
      $con->rollBack();
      return -1;
    }
  }

  public static function get_ticket_all($con, $query)
  {
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

  public static function index($con, $data)
  {
    try {
      $client = $data['client'];
      $trip_id = $data['trip_id'] ?? 0;
      $filterByDestination = intval($trip_id) > 0 ? "AND t.trip_id = $trip_id" : "";
      $sql = "SELECT * FROM (
      SELECT DISTINCT t.client_id, t.price as sold_price, FORMAT(t.created_at, 'yyyy-MM-dd HH:mm') as sold_datetime, b.description as bus_description, b.placa, tr.*, o.location as origin, d.location as destination, e.ci, e.nit, CONCAT(e.name, ' ', e.lastname, ' ', e.mothers_lastname) AS client, i.location AS intermediate, u.username, t.status, tr.price as trip_price, tr.min_price as trip_min_price FROM tickets t LEFT JOIN trips tr ON t.trip_id = tr.id LEFT JOIN locations o ON tr.location_id_origin = o.id LEFT JOIN locations d ON tr.location_id_dest = d.id LEFT JOIN locations i ON t.intermediate_id = i.id LEFT JOIN clients e ON t.client_id = e.id LEFT JOIN buses b ON b.id = tr.bus_id LEFT JOIN users u ON u.id = t.sold_by WHERE CONCAT(e.name, ' ', e.lastname, ' ', e.mothers_lastname) LIKE '%$client%' $filterByDestination ) as temporal LEFT JOIN (
      SELECT client_id, STRING_AGG(seat_number,'-') as seat_number from tickets GROUP BY client_id
      ) as asientos ON temporal.client_id = asientos.client_id;";
      // echo $sql;
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }

  public static function countSumTicket($con, $trip_id)
  {
    try {
      $sql = "SELECT price, COUNT(price) as countTickets, SUM(price) as sumTickets  FROM tickets WHERE trip_id = '$trip_id' GROUP BY price;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
    }
  }
  /**
   * @return array de los numeros de asientos de un mismo viaje que compro un cliente
   */
  public static function tickets_by_client($con, $trip_id, $client_id)
  {
    try {
      $sql = "SELECT seat_number FROM tickets WHERE trip_id = ? AND client_id = ?";
      $stmt = $con->prepare($sql);
      $stmt->execute([$trip_id, $client_id]);
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $arrSeats = [];
      foreach ($rows as $row) {
        $arrSeats[] = $row['seat_number'];
      }
      return $arrSeats;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }
  public static function ticket_by_seat($con, $trip_id, $seat_number): Ticket
  {
    $ticket = new Ticket($con);
    try {
      $sql = "SELECT a.*, b.lastname FROM tickets a INNER JOIN clients b ON a.client_id = b.id 
          WHERE a.trip_id = $trip_id AND a.seat_number = '$seat_number';";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row) {
        $ticket->load($row);
        $ticket->{'client'} = $row['lastname'];
      }
    } catch (\Throwable $th) {
      //throw $th;
    }
    return $ticket;
  }
  public static function are_sold($con, $trip_id, $seats): bool
  {
    try {
      $cad = '';
      foreach ($seats as $seat) {
        $cad .= "'$seat',";
      }
      $cad = substr($cad, 0, -1);
      $sql = "SELECT count(*) as cantidad FROM tickets WHERE trip_id = $trip_id AND seat_number IN ($cad);";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $c = $stmt->fetch(PDO::FETCH_ASSOC)['cantidad'];
      if ($c > 0)
        return true;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return false;
  }
}

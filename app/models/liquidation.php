<?php

namespace App\Models;

use PDO;

class Liquidation {
  private $con;
  public int $id;
  public int $trip_id;
  public float $discount;
  public string $observation;
  public float $observation_discount;
  public float $correspondence;
  /* INICIO  por trip_id*/
  public function __construct($con = null, $trip_id = null) {
    $this->objectNull();
    if ($con != null) {
      $this->con = $con;
      if ($trip_id != null) {
        $sql = "SELECT * FROM liquidations WHERE trip_id = $trip_id";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row)
          $this->load($row);
      }
    }
  }
  public function save() {
    if ($this->con == null)
      return -1;
    try {
      $sql = "INSERT INTO liquidations(trip_id, discount, observation, observation_discount, correspondence) VALUES(?, ?, ?, ?, ?);";
      $stmt = $this->con->prepare($sql);
      $res = $stmt->execute([$this->trip_id, $this->discount, $this->observation, $this->observation_discount, $this->correspondence]);
      if ($res) {
        $this->id = $this->con->lastInsertId();
        return $this->id;
      }
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return -1;
  }
  public function update() {
    if ($this->con == null)
      return -1;
    try {
      $sql = "UPDATE liquidations SET discount = ?, observation = ?, observation_discount = ?, correspondence = ? WHERE id = ?;";
      $stmt = $this->con->prepare($sql);
      $res = $stmt->execute([$this->discount, $this->observation, $this->observation_discount, $this->correspondence, $this->id]);
      if ($res) {
        return $this->id;
      }
    } catch (\Throwable $th) {
      var_dump($th);
    }
  }
  public function objectNull() {
    $this->id = 0;
    $this->trip_id = 0;
    $this->discount = 0;
    $this->observation = '';
    $this->observation_discount = 0;
    $this->correspondence = 0;
  }
  public function load($row) {
    $this->id = $row['id'];
    $this->trip_id = $row['trip_id'];
    $this->discount = $row['discount'];
    $this->observation = $row['observation'] ?? '';
    $this->observation_discount = $row['observation_discount'] ?? 0;
    $this->correspondence = $row['correspondence'] ?? 0;
  }
}

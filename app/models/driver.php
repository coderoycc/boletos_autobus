<?php

namespace App\Models;

use PDO;

class Driver {
  private $con;
  public int $id;
  public string $fullname;
  public string $license;
  public string $category;
  public string $state;
  public function __construct($con = null, $id = null) {
    $this->objectNull();
    if ($con != null) {
      $this->con = $con;
      if ($id != null) {
        $sql = "SELECT * FROM drivers WHERE id=:id";
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
    $this->fullname = "";
    $this->license = "";
    $this->category = "";
    $this->state = '';
  }

  public function load($row) {
    $this->id = $row['id'];
    $this->fullname = $row['fullname'];
    $this->category = $row['category'];
    $this->license = $row['license'];
    $this->state = $row['state'];
  }
  public function save() {
    if ($this->con == null) {
      return -1;
    }
    try {
      $resp = 0;
      $this->con->beginTransaction();
      $sql = "INSERT INTO drivers (fullname, category, license, state) VALUES (:fullname, :category, :license, :state);";
      $params = [
        'category' => $this->category,
        'fullname' => $this->fullname,
        'license' => $this->license,
        'state' => $this->state
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

    $this->con->beginTransaction();
    try {
      $resp = 0;
      $sql = "UPDATE drivers SET fullname = :fullname, category = :category, license = :license
              WHERE id = :id;";
      $params = [
        'category' => $this->category,
        'fullname' => $this->fullname,
        'license' => $this->license,
        'state' => $this->state,
        'id' => $this->id
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
  public static function all($con) {
    $sql = "SELECT * FROM drivers";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
  }
}

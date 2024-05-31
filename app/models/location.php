<?php

namespace App\Models;

use PDO;

class Location {
  private $con;
  public int $id;
  public string $location;
  public string $acronym;
  public function __construct($db = null, $id = null) {
    $this->objectNull();
    if ($db != null) {
      $this->con = $db;
      if ($id != null) {
        $sql = "SELECT * FROM locations WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row)
          $this->load($row);
      }
    }
  }
  public function objectNull() {
    $this->id = 0;
    $this->location = '';
    $this->acronym = '';
  }
  public function load($row) {
    $this->id = $row['id'];
    $this->location = $row['location'];
    $this->acronym = $row['acronym'] ?? '';
  }
  public function save(): bool {
    try {
      if ($this->id == 0) {
        $sql = "INSERT INTO locations (location, acronym) VALUES (?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->location, $this->acronym]);
        $this->id = $this->con->lastInsertId();
      } else {
        $sql = "UPDATE locations SET location = ?, acronym = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([$this->location, $this->acronym, $this->id]);
      }
      return true;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return false;
  }

  public static function all($con) {
    try {
      $sql = "SELECT * FROM locations;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $rows;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return [];
  }
}

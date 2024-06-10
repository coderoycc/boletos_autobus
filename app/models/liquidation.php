<?php

namespace App\Models;

use PDO;

class Liquidation
{
    private $con;
    public int $id;
    public int $trip_id;
    public float $discount;
    public string $observation;
    public float $observation_discount;
    public float $correspondence;

    public function __construct($con = null, $id = null)
    {
        $this->objectNull();
        if ($con != null) {
            $this->con = $con;
            if ($id != null) {
                $sql = "SELECT * FROM liquidations WHERE trip_id=$id";
                $stmt = $this->con->query($sql);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $this->load($row);
                }
            }
        }
    }
    public function objectNull()
    {
        $this->id = 0;
        $this->trip_id = 0;
        $this->discount = 0;
        $this->observation = "";
        $this->observation_discount = 0;
        $this->correspondence = 0;
    }
    public function load($row)
    {
        $this->id = $row['id'];
        $this->trip_id = $row['trip_id'];
        $this->discount = $row['discount'];
        $this->observation = $row['observation'];
        $this->observation_discount = $row['observation_discount'];
        $this->correspondence = $row['correspondence'];
    }
}

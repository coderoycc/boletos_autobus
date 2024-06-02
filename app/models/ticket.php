<?php

namespace App\Models;

use PDO;

class Ticket {

    private $con;

    public function __construct($db = null){
        $this->objectNull();
        if($db){
            $this->con = $db;
        }
    }

    public static function reservedSeats($con, $trip_id){
        try{
            $sql = "SELECT t.seat_number
                    FROM tickets t
                    WHERE t.trip_id = :trip_id;";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                'trip_id' => $trip_id
            ]);
            $seats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $res = [];
            foreach($seats as $seat){
                array_push($res, $seat['seat_number']);
            }
            return $res;
        }catch(\Throwable $th){
            //var_dump($th);
        }
        return [];
    }

}
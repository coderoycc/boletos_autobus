<?php

namespace App\Models;

use PDO;

class Distribution {

    private $con;

    public function __construct($db = null){
        $this->objectNull();
        if($db){
            $this->con = $db;
        }
    }

    public static function getDistributionData($con, $id){
        try{
            $sql = "SELECT ds.col1, ds.col2, ds.col3, ds.col4, ds.col5, ds.floor
                    FROM distributions d
                    LEFT JOIN distro_seats ds ON d.id = ds.distro_id
                    WHERE d.id = :distribution_id;";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                'distribution_id' => $id,
            ]);
            $distributions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $res = null;
            if(count($distributions) > 0){
                $res = [ '1' => [], '2' => [] ];
                foreach($distributions as $distribution){
                  $row = [];
                  $floor = $distribution['floor'];
                  foreach($distribution as $key => $column){
                    if($key != 'floor'){
                        array_push($row, $column);
                    }
                  }
                  array_push($res[$floor], $row);
                }
            }
            return $res;
        }catch(\Throwable $th){
            //var_dump($th);
        }
        return [];
    }
    public static function distros($con){
        try {
            $sql = "SELECT * FROM distributions;";
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
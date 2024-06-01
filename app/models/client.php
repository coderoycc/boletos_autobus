<?php

namespace App\Models;

use PDO;

class Client {

    private $con;
    public int $id;
    public string $name;
    public string $lastname;
    public string $mothers_lastname;
    public string $ci;
    public string $nit;
    public int $is_minor;
    public int $user_id;
    public string $created_at;

    public function __construct($db = null){
        $this->objectNull();
        if($db){
            $this->con = $db;
        }
    }

    public function objectNull() {
        $this->id = 0;
        $this->name = '';
        $this->lastname = '';
        $this->mothers_lastname = '';
        $this->ci = '';
        $this->nit = '';
        $this->is_minor = 0;
        $this->user_id = 0;
        $this->created_at = '';
    }

    public function save(){
        if ($this->con == null){ return -1; }
        try{
            $resp = 0;
            $this->con->beginTransaction();
            $sql = "INSERT 
                    INTO clients (name, lastname, mothers_lastname, ci, nit, is_minor, user_id, created_at) 
                    VALUES (:name, :lastname, :mothers_lastname, :ci, :nit, :is_minor, :user_id, :created_at);";
            $params = [
                'name' => $this->name, 'lastname' => $this->lastname,
                'mothers_lastname' => $this->mothers_lastname,
                'ci' => $this->ci, 'nit' => $this->nit,
                'is_minor' => $this->is_minor, 'user_id' => $this->user_id,
                'created_at' => $this->created_at,
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
        }catch(\Throwable $th){
            //print_r($th);
            $this->con->rollBack();
            return -1;
        }
    }

    public static function getByCi($con, $ci){
        try{
            $sql = "SELECT c.id, c.name, c.lastname, c.mothers_lastname, 
                            c.ci, c.nit, c.is_minor
                    FROM clients c
                    WHERE (c.ci LIKE '%$ci%' AND '$ci' <> '');";
            $stmt = $con->prepare($sql);
            $stmt->execute([]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(\Throwable $th){
            //var_dump($th);
        }
        return [];
    }

    public static function getByNit($con, $nit){
        try{
            $sql = "SELECT c.id, c.name, c.lastname, c.mothers_lastname, 
                            c.ci, c.nit, c.is_minor
                    FROM clients c
                    WHERE (c.nit LIKE '%$nit%' AND '$nit' <> '');";
            $stmt = $con->prepare($sql);
            $stmt->execute([]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(\Throwable $th){
            //var_dump($th);
        }
        return [];
    }

}
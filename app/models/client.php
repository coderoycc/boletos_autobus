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

    public function __construct($db = null, $id = null){
        $this->objectNull();
        if($db){
            $this->con = $db;
            if ($id != null) {
                $sql = "SELECT * 
                        FROM clients WHERE id = :id";
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
        $this->name = $row['name'];
        $this->lastname = $row['lastname'];
        $this->mothers_lastname = $row['mothers_lastname'];
        $this->ci = $row['ci'];
        $this->nit = $row['nit'];
        $this->is_minor = $row['is_minor'];
        $this->user_id = $row['user_id'];
        $this->created_at = $row['created_at'];
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
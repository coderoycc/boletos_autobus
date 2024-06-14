<?php

namespace App\Controllers;

use App\Models\Client;
use App\Providers\DBWebProvider;
use Helpers\Resources\Response;
use Helpers\Resources\Render;

class ClientController {

    public function showByCi($query){
        $con = DBWebProvider::getSessionDataDB();
        if($con){
            $ci = $query['ci'];
            $res = Client::getByCi($con, $ci);
            if(count($res) > 0){
                Response::success_json('Búsqueda realizada correctamente.', $res);
            }else{
                Response::error_json(['message' => 'No se encontraron coincidencias con el CI.'], 200);    
            }
        }else{
            Response::error_json(['message' => 'Sin conexión a la base de datos.'], 200);
        }
    }

    public function showByNit($query){
        $con = DBWebProvider::getSessionDataDB();
        if($con){
            $nit = $query['nit'];
            $res = Client::getByNit($con, $nit);
            if(count($res) > 0){
                Response::success_json('Búsqueda realizada correctamente.', $res);
            }else{
                Response::error_json(['message' => 'No se encontraron coincidencias con el NIT.'], 200);    
            }
        }else{
            Response::error_json(['message' => 'Sin conexión a la base de datos.'], 200);
        }
    }

    public function create($data){
        $con = DBWebProvider::getSessionDataDB();
        if ($con) {
            /*if(Client::existsByCi($con, $data['ci']))
                Response::error_json(['message' => 'El CI ingresado ya se encuentra registrado.'], 200);


            if(Client::existsByNit($con, $data['nit']))
                Response::error_json(['message' => 'El NIT ingresado ya se encuentra registrado.'], 200);*/
               
            $client = new Client($con);
            $client->name = $data['name'];
            $client->lastname = $data['lastname'];
            $client->mothers_lastname = $data['mothers_lastname'];
            $client->ci = $data['ci'];
            $client->nit = $data['nit'];
            $client->is_minor = isset($data['is_minor']) ? 1 : 0;
            $client->user_id = json_decode($_SESSION['user'])->id;
            $client->created_at = date('Y-m-d H:i:s');
            $res = $client->save();
            if($res){
                Response::success_json('Cliente creado correctamente.', ['client' => $client]);
            }else{
                Response::error_json(['message' => 'Error al crear el cliente.'], 200);
            }
        }else{
            Response::error_json(['message' => 'Error conexion instancia.'], 200);
        }
    }

    public function getAllClientsView($query){
        $con = DBWebProvider::getSessionDataDB();
        $clients = Client::getAllClients($con);
        Render::view('clients/client_list_view', ['clients' => $clients]);
    }

}
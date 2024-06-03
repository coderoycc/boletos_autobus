<?php

namespace App\Controllers;

use App\Models\Distribution;
use App\Providers\DBWebProvider;
use Helpers\Resources\Render;
use Helpers\Resources\Response;

class DistributionController {
  public function card_distro_seats($query){
    $con = DBWebProvider::getSessionDataDB();
    // $distribution = 
    Render::view('distros/card_seats_distro',[]);
  }
    

}
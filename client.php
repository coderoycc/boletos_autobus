<?php

    $response = array (
        'success' => true,
        'message' => "Consulta realizada con éxito.",
        'data' => [
            'client' => [
                'id' => 1,
                'name' => 'Jiuseppe',
                'lastname' => 'Flores',
                'mothers_lastname' => 'Quisbert',
                'ci' => '123456',
                'nit' => '789456',
                'is_child' => 0,
            ]
        ],
    );

    echo json_encode($response);
    
?>
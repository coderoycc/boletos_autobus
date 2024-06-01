<?php

    $response = array (
        'success' => true,
        'message' => "Consulta realizada con éxito.",
        'data' => [
            'reserved' => [
                '33', '39', '40', '50', '55',
            ]
        ],
    );

    echo json_encode($response);
    
?>
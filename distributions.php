<?php

    $response = array (
        'success' => true,
        'message' => "Consulta realizada con éxito.",
        'data' => [
            'trip' => array(
                'id' => 1,
                'departure_date' => '2024-06-01',
                'departure_time' => '18:50',
                'base_price' => 50.00,
            ),
            'departure' => array(
                'location' => 'la paz',
                'acronym' => 'lp',
            ),
            'destination' => array(
                'location' => 'oruro',
                'acronim' => 'or',
            ),
            'bus' => array(
                'id' => 1,
                'placa' => '890-PLT',
                'description' => 'Bus Normal',

            ),
            'floor1' => array(
                ['4',   '3',    null,   '2',    '1' ],
                ['8',   '7',    null,   '6',    '5' ],
                ['12',  '11',   null,   '10',   '9' ],
                ['16',  '15',   null,   '14',   '13'],
                ['20',  '19',   null,   '18',   '17'],
                [null,  null,   null,   null,   null],
                [null,  null,   null,   null,   null],
                [null,  null,   null,   null,   null],
                [null,  null,   null,   null,   null],
            ),
            'floor2' => array(
                ['24',  '23',   null,   '22',   '21'],
                ['28',  '27',   null,   '26',   '25'],
                ['32',  '31',   null,   '30',   '29'],
                ['36',  '35',   null,   '34',   '33'],
                ['40',  '39',   null,   '38',   '37'],
                ['44',  '43',   null,   '42',   '41'],
                ['48',  '47',   null,   '46',   '45'],
                ['52',  '51',   null,   '50',   '49'],
                ['57',  '56',   '55',   '54',   '53'],
            ),
            'reserved' => [
                '1', '19', '34', '49', '53',
            ]
        ],
    );

    echo json_encode($response);
    
?>
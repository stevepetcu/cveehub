<?php

return [
    'doctrine' => [
        'connections' => [
            'master' => [
                'driver' => 'pdo_sqlite',
                'path' => ':memory:?cache=cveehub'
            ]
        ]
    ],
];

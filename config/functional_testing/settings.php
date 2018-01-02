<?php

return [
    'doctrine' => [
        'connections' => [
            'master' => [
                'driver' => 'pdo_sqlite',
                'path' => PATH_ROOT . '/cveehub_sqlite_db'
            ]
        ]
    ],
];

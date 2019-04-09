<?php

return [
    'role_structure' => [
        'superadministrator',
        'editor' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'user' => [
            'profile' => 'r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'v' => 'view',
        'va' => 'view_all',
        'u' => 'update',
        'd' => 'delete'
    ]
];

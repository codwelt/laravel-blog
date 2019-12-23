<?php
return [

    /**
     * Es el modelo que va crear los posts
     */
    'creatorPost' => [
        'model' => App\User::class,
        'columnOfRelation' => 'id'
    ],
    'commentatorPost' => [
        'model' => App\User::class,
        'columnOfRelation' => 'id'
    ],
    'routes' => [

        /**
         * Middlewares que se aplicaran a las rutas
         */
        'middlewares' => [
            'web' => [
                'admin' => [
                    'web',
                   // 'auth'
                ],
                'user' => [
                    'web',
                    \Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'_robotsHTTP'
                ]
            ],
            'api' => [
                'user' => [
                    'web'
                ]
            ]
        ]
    ]
];
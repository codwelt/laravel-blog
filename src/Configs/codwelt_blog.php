<?php
return [
    "api" => [
        'front' => [ //En el caso de que use el api para usar con algun framework front como angular, etc. Esto se usara para generar los meta tags del post y del blog
            'site' => env('API_BLOG_SITE','http://localhost'), //url del dominio absoluto del blog
            'home' => env('API_BLOG_URL','http://localhost/test/blog'), //url de donde se encuentra la pagina principal del blog
            'posts' => env('API_BLOG_POST','http://localhost/test/blog/post/'), //url de donde van a quedar los posts
        ]
    ],

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

                ]
            ]
        ]
    ]
];
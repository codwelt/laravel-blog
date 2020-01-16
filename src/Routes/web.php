<?php

Route::group(['prefix' => '/blog', 'as' => \Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.'],function(){

    //Pagina de administracion
    Route::group(['middleware' => config(\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.routes.middlewares.web.admin')], function(){
        // *********************** Administracion ***************************
        Route::group(['prefix' => 'admin', 'as' => 'admin.'],function(){

            // Posts
            Route::group(['prefix' => 'posts', 'as' => 'posts.'],function(){

                Route::get('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\PostController@index',
                ]);

                Route::get('/create',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\PostController@create',
                    'as' => 'create'
                ]);

                Route::post('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\PostController@store',
                    'as' => 'store'
                ]);

                Route::get('/{postID}/show',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\PostController@edit',
                    'as' => 'show'
                ]);

                Route::put('/{postID}',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\PostController@update',
                    'as' => 'update'
                ]);

                Route::delete('/{postID}',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\PostController@destroy',
                    'as' => 'destroy'
                ]);

            });

            //Configuracion
            Route::group(['prefix' => 'config', 'as' => 'config.'],function(){


                Route::get('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\ConfigurationController@index',
                    'as' => 'index'
                ]);

                Route::put('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\Admin\ConfigurationController@update',
                    'as' => 'update'
                ]);
            });

        });
    });

    // ********************************************* Usuarios *****************************************
    //
    Route::group([
        'middleware' => config(\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.routes.middlewares.web.user')
    ],function(){
        //Pagina principal
        Route::get('/',[
            'uses' => 'Codwelt\Blog\Http\Controllers\User\PostController@index',
            'as' => 'index'
        ]);
        //Detalle del post
        Route::get('/posts/{slug}',[
            'uses' => 'Codwelt\Blog\Http\Controllers\User\PostController@show',
            'as' => 'show'
        ]);

    });

});


<?php
Route::prefix('api')->group(function () {
    Route::group(['prefix' => 'blog','middleware' => ['api',\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'_api'], 'as' => 'api.'.\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.'], function () {

        //Usuario
        Route::group(['prefix' => 'user', 'as' => 'user.','middleware' => config(\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.routes.middlewares.api.user')],function(){


            Route::group(['prefix' => 'posts', 'as' => 'posts.'],function(){

                Route::get('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\User\PostJsonController@index',
                    'as' => 'index'
                ]);

                Route::get('/{slug}',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\User\PostJsonController@show',
                    'as' => 'show'
                ]);

                Route::get('/related/{postID}',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\User\PostJsonController@related',
                    'as' => 'related'
                ]);

            });

            Route::group(['prefix' => 'hashtags', 'as' => 'hashtags.'],function(){

                Route::get('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\User\HashTagsJsonController@index',
                    'as' => 'index'
                ]);

            });

            Route::group(['prefix' => 'comments','as' => 'comments.'],function(){

                Route::get('/search',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\User\CommentsJsonController@search',
                    'as' => 'search'
                ]);

                Route::post('/',[
                    'uses' => 'Codwelt\Blog\Http\Controllers\User\CommentsJsonController@store',
                    'as' => 'store'
                ]);
            });

        });

    });

});
<?php


namespace Codwelt\Blog\Tests\Posts;


use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Operations\Models\StatePost;
use Codwelt\Blog\Tests\means\models\User;
use Codwelt\Blog\Tests\TestCaseSon;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class Posts
 * @package Codwelt\Blog\Tests\Posts
 * @author FuriosoJack <iam@furiosojack.com>
 */
class PostsTestSon extends TestCaseSon
{




    /**
     * @test
     */
    public function storePost()
    {


        $pathImage = test_path_codwelt_blog('/means/assets/images/composer-laravel.png');


        ///Se crear usuario para autenticar al usuario
        $user = $this->createUser();

        Auth::login($user);
        //Se obtiene la imagen a subir y se crea un archivo de subir
        $imagen = new UploadedFile($pathImage, 'large-avatar.jpg', 'image/png', null, null, true);

        //Se hace el llamado a la ruta para crear post
        $response = $this->call('POST', route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.store'), [
            'titulo' => 'titulo de prueba',
            'slug' => 'tutlo-de-prueba',
            'hashtags' => [
                [
                    'nombre' => 'prueba'
                ]
            ],
            'state' => StatePost::PUBLISHED,
            'resumen' => 'resument de prueba',
            'meta_keywords' => 'metaeprueba',
            'contenido' => 'contenido de prueba'

        ], [], [
            'imagen' => $imagen
        ]);




        $response = $this->assertResponseStatus(302)->followRedirects($this);

        $encodeID = Hashids::encode(1);

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.show',['postID' => $encodeID]));
     //   dd($response->response);
        $response->assertResponseStatus(200);

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT.'.index'));

        $response->assertResponseStatus(200);




    }

    /**
     * @test
     */
    public function getPostAPIJson()
    {

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT. '.api.user.posts.',['output' => 'ramdom']));
        //dd($response);
        $response->assertResponseStatus(200);
    }





}

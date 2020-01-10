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
    public function adminWebCrearPostBorrador()
    {

        //Autenticar usuario https://medium.com/yish/how-to-mock-authentication-user-on-unit-test-in-laravel-1441d491d82c
        $usuario = $this->createUser();
        $reponse = $this->actingAs($usuario)->post(route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.store'), [
            'titulo' => "Test de POST",
            'slug' => "test-de-post",
            "state" => StatePost::DRAFT
        ]);


        $reponse->assertRedirectedTo(route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.'));

    }

    /**
     * @test
     */
    public function adminWebCrearPostPublishedFail()
    {

        //Autenticar usuario https://medium.com/yish/how-to-mock-authentication-user-on-unit-test-in-laravel-1441d491d82c
        $usuario = $this->createUser();
        $reponse = $this->actingAs($usuario)->post(route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.store'), [
            'titulo' => "Test de POST",
            'slug' => "test-de-post",
            "state" => StatePost::PUBLISHED
        ])->assertResponseStatus(302);

    }

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
        $imageUpload = new UploadedFile($pathImage, 'large-avatar.jpg', 'image/png', null, true);

       // $imageUpload = UploadedFile::fake();


        $dataParameter = [
            'titulo' => 'titulo de prueba',
            'slug' => 'tutlo-de-prueba',
            'hashtags' => [
                'prueba'
            ],
            'state' => StatePost::PUBLISHED,
            'resumen' => 'resument de prueba',
            'meta_keywords' => 'metaeprueba,,',
            'contenido' => 'contenido de prueba'
        ];


        $response = $this->call('POST',route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.store'),$dataParameter,[],['imagen' => $imageUpload]);
        //Se hace el llamado a la ruta para crear post



        $response = $this->assertResponseStatus(302)->followRedirects($this);

        $encodeID = Hashids::encode(1);

        $response = $response->get(route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.show', ['postID' => $encodeID]));

        $response->assertResponseStatus(200);

        $response = $response->get(route(BlogServiceProvider::NAMESPACE_PROYECT . '.index'));

        $response->assertResponseStatus(200);

        $this->assertStringContainsString($dataParameter["titulo"],$response->response->content());

        $response = $response->get(route(BlogServiceProvider::NAMESPACE_PROYECT . '.api.user.posts.show', ['slug' => $dataParameter["slug"]]));

        dd($response->response->content());
        $this->assertStringContainsString($dataParameter["titulo"],$response->response->content());




    }



    /**
     * @test
     */
    public function searchWebPost()
    {


        $pathImage = test_path_codwelt_blog('/means/assets/images/composer-laravel.png');


        ///Se crear usuario para autenticar al usuario
        $user = $this->createUser();

        Auth::login($user);
        //Se obtiene la imagen a subir y se crea un archivo de subir
        $imageUpload = new UploadedFile($pathImage, 'large-avatar.jpg', 'image/png', null, true);

        // $imageUpload = UploadedFile::fake();


        $dataParameter = [
            'titulo' => 'titulo de prueba',
            'slug' => 'tutlo-de-prueba',
            'hashtags' => [
                'prueba'
            ],
            'state' => StatePost::PUBLISHED,
            'resumen' => 'resument de prueba',
            'meta_keywords' => 'metaeprueba,,',
            'contenido' => 'contenido de prueba'
        ];


        $this->call('POST',route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.store'),$dataParameter,[],['imagen' => $imageUpload]);
        //Se hace el llamado a la ruta para crear post


        $response = $this->assertResponseStatus(302)->followRedirects($this);



        $url = route(BlogServiceProvider::NAMESPACE_PROYECT. ".index",['query' => "prueba"]);


        $response = $response->get($url);


        $this->assertStringContainsString("tutlo-de-prueba",$response->response->content());

    }


    /**
     * @test
     */
    public function getPostAPIJson()
    {

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT . '.api.user.posts.index', ['output' => 'ramdom']));
        //dd($response);
        $response->assertResponseStatus(200);
    }


}

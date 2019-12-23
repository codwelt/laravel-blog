<?php
namespace Codwelt\Blog\Tests\Routes;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Operations\Constants\ExcepcionConstants;
use Codwelt\Blog\Operations\SEO\SitemapBlog;
use Codwelt\Blog\Tests\TestCaseSon;
use DOMDocument;
use Laravelium\Sitemap\SitemapServiceProvider;



/**
 * Class RouteTestSon
 * @package CodWelt\Blog\Tests\Routes
 * @author FuriosoJack <iam@furiosojack.com>
 */
class RouteTestSon extends TestCaseSon
{

    /**
     * Realiza el test a la pagina de administracion principal, lista de posts
     * @test
     */
    public function adminShowListPosts()
    {

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT.'.admin.posts.'));

        $response->assertResponseStatus(200);
    }

    /**
     * Realiza test a la ruta de crear post
     * @test
     */
    public function adminShowCretatePost()
    {

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT.'.admin.posts.create'));

        $response->assertResponseStatus(200);
    }


    /**
     * al detalle del post Pero como no existen post Se valida que el mensaje de la excepcion sea igual
     * @test
     */
    public function adminShowPost()
    {
        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT. '.admin.posts.show',['postID' => 1]));
        $response->assertResponseStatus(404);

    }


    /**
     * @test
     */
    public function adminShowConfig()
    {
        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT.'.admin.config.index'));
        $response->assertResponseStatus(200);
    }


    /**
     * @test
     */
    public function userShowIndex()
    {
        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT.'.index'));
        $response->assertResponseStatus(200);
    }

    /**
     * @test
     */
    public function userShowDetailPost()
    {

        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT.'.show',['slug'=> 'slug']));
        $response->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function showSiteMap()
    {
        $this->artisan("vendor:publish",[
            '--provider' => SitemapServiceProvider::class
            ]);

        $sitemap = app()->make('sitemap');

        SitemapBlog::generate($sitemap);

        $render = $sitemap->render('xml');

        $domBasic = new DOMDocument();

        $domBasic->loadXML('<?xml version="1.0" encoding="UTF-8"?>
                <?xml-stylesheet href="http://localhost/vendor/sitemap/styles/xml.xsl" type="text/xsl"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
                </urlset>');

        $domActual = new DOMDocument();

        $domActual->loadXML($render->original);

        $this->assertEqualXMLStructure($domActual->documentElement,$domBasic->documentElement);
    }


    /**
     * @test
     */
    public function apiShowHashtags()
    {
        $response = $this->get(route(BlogServiceProvider::NAMESPACE_PROYECT. '.api.user.hashtags.index'));
        $response->assertResponseStatus(200);
    }



}
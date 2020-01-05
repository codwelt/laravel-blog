<?php
namespace Codwelt\Blog\Tests;

use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Tests\means\models\User;


use Illuminate\Foundation\Testing\TestResponse;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use Laravel\Scout\ScoutServiceProvider;

use Laravelium\Sitemap\SitemapServiceProvider;
use Vinkla\Hashids\Facades\Hashids;
use Artesaos\SEOTools\Providers\SEOToolsServiceProvider;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\SEOTools;
use Orchestra\Testbench\BrowserKit\TestCase as TestFather;
use Vinkla\Hashids\HashidsServiceProvider;
use Yab\MySQLScout\Providers\MySQLScoutServiceProvider;

/**
 * Class TestCaseSon
 * @author FuriosoJack <iam@furiosojack.com>
 */
class TestCaseSon extends TestFather
{

    public function getPackageProviders($app)
    {
        return [
            BlogServiceProvider::class,
            HashidsServiceProvider::class,
            SEOToolsServiceProvider::class,
            SitemapServiceProvider::class,
            ImageServiceProvider::class


        ];
    }

    public function getPackageAliases($app)
    {
        return [
           'Hashids' => Hashids::class,
            'SEOMeta'   => SEOMeta::class,
            'OpenGraph' => OpenGraph::class,
            'Twitter'   => TwitterCard::class,
            'SEO' => SEOTools::class,
            'Image' => Image::class
        ];
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->install();
        $this->withFactories(test_path_codwelt_blog('means/database/factories'));


        TestResponse::macro('followRedirects',function($testCase){

            $response = $this;

            while ($response->isRedirect()) {
                $response = $testCase->get($response->headers->get('Location'));
            }

        });

    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Se crean las migraciones necesarias para el funcionamiento
     */

    protected function install()
    {

        $migrator = app('migrator');


        if (!$migrator->repositoryExists()) {
            $this->artisan('migrate:install');
        }
        $realPath = realpath(__DIR__.'/../src/Database/Migrations');



        //MIgraciones del paquete
        $migrator->run([$realPath]);
        $this->artisan('migrate', ['--path' => $realPath]);


        //migraciones para test
        $pathTest = test_path_codwelt_blog('means/database/migrations');
        $migrator->run([$pathTest]);
        $this->artisan('migrate',['--path' =>$pathTest]);

        $this->artisan(BlogServiceProvider::NAMESPACE_PROYECT.':install');

        $this->artisan('storage:link');

        $pathCnfig = base_path('config/'.BlogServiceProvider::NAMESPACE_PROYECT.'.php');
        if (file_exists($pathCnfig)) {
            $str = file_get_contents($pathCnfig);
            if ($str !== false) {
                $str = str_replace("App\User::class", "Codwelt\Blog\Tests\means\models\User::class", $str);
                file_put_contents($pathCnfig, $str);
            }
        }
        //limpieza para el remplazo de modelo funcione
        $this->artisan('config:clear');
    }

    protected function createUser()
    {

        return factory(User::class)->create();
    }






}
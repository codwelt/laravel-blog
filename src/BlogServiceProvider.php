<?php
namespace Codwelt\Blog;

use Codwelt\Blog\Blade\BlogExtension;
use Codwelt\Blog\Commands\InstallCommand;
use Codwelt\Blog\Commands\UpdateCommand;
use Codwelt\Blog\Http\Middlewares\APIMiddleware;
use Codwelt\Blog\Http\Middlewares\RobotsHTTPMiddleware;
use Codwelt\Blog\Managers\CodweltBlogManager;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class BlogServiceProvider
 * @author FuriosoJack <iam@furiosojack.com>
 */
class BlogServiceProvider extends ServiceProvider
{

    const NAMESPACE_PROYECT = "codwelt_blog";

    const TAGS_PUBLISHED = [
      'views' =>   self::NAMESPACE_PROYECT.'_views',
      'seeds' => self::NAMESPACE_PROYECT.'_seeds',
      'config_hashids' => self::NAMESPACE_PROYECT.'_config_hashids',
      'config_seotools' => self::NAMESPACE_PROYECT.'_config_seotools',
      'config_'.self::NAMESPACE_PROYECT => self::NAMESPACE_PROYECT.'_config_core'
    ];

    public function boot(Router $router)
    {

        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        $this->loadViewsFrom(__DIR__.'/Views',self::NAMESPACE_PROYECT);


        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');



        $this->registerHelpers();

        $this->publishFiles();

        $this->registerCommands();

        $router->aliasMiddleware(self::NAMESPACE_PROYECT.'_robotsHTTP', RobotsHTTPMiddleware::class);
        $router->aliasMiddleware(self::NAMESPACE_PROYECT.'_api', APIMiddleware::class);



    }

    public function register()
    {

        //Si algunas configuracion no esta defiinida por el usuario se tomara la que tenga el archivo de configuracion del paquete
        $this->mergeConfigFrom(__DIR__ . '/Configs/'. self::NAMESPACE_PROYECT .'.php', self::NAMESPACE_PROYECT);

        //Registro de metodos para blade
        blade_extension(BlogExtension::class);

        //Se registra el singleton
        $this->app->singleton('CodweltBlogManager',function(){
            return new CodweltBlogManager();
        });
    }

    /**
     * Carga los helpers que se hallan creado
     */
    private function registerHelpers()
    {
        foreach (glob(__DIR__."/Helpers/*.php") as $fileName){
            require_once $fileName;
        }
    }

    public function publishFiles()
    {

        $publishable = [
            self::TAGS_PUBLISHED['views'] => [
                __DIR__.'/Views' => resource_path('views/vendor/'.self::NAMESPACE_PROYECT),
            ],
            self::TAGS_PUBLISHED['config_hashids'] => [
                __DIR__ . '/Configs/hashids.php' => config_path('hashids.php')
            ],
            self::TAGS_PUBLISHED['config_seotools'] => [
                __DIR__ . '/Configs/seotools.php.php' => config_path('seotools.php')
            ],
            self::TAGS_PUBLISHED['config_'.self::NAMESPACE_PROYECT] => [
                __DIR__ . '/Configs/'.self::NAMESPACE_PROYECT . '.php' => config_path(self::NAMESPACE_PROYECT.'.php')
            ]
        ];

        foreach ($publishable as $tag => $path){
            $this->publishes($path,$tag);
        }

    }

    public function registerCommands()
    {
        if($this->app->runningInConsole()){
            $this->commands([
                InstallCommand::class,
                UpdateCommand::class
            ]);

        }
    }





}
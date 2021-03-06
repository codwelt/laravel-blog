<?php


namespace Codwelt\Blog\Commands;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Models\Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Diff\Differ;


/**
 * Class Install
 * @package CodWelt\Blog\Commands
 * @author FuriosoJack <iam@furiosojack.com>
 */
class InstallCommand extends Command
{

    protected $signature = BlogServiceProvider::NAMESPACE_PROYECT.":install {--test=  : por defecto es false se se indica en true no se ejecutan migraciones}";


    protected $description = "Hace la instanacion y configura los archivos seeds necesarios para el funcionamiento";



    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    public function handle(Filesystem $filesystem)
    {




        /*$this->info("Publicando Vistas.");

        $this->call('vendor:publish', ['--provider' => BlogServiceProvider::class, '--tag' => [BlogServiceProvider::TAGS_PUBLISHED['views']]]);

        $this->info("Publicando Configuracion de busqueda(scout).");

        $this->call('vendor:publish', ['--provider' => BlogServiceProvider::class, '--tag' => [BlogServiceProvider::TAGS_PUBLISHED['config.search']]]);

        $this->info("Publicando Configuracion de hashids").

        $this->call('vendor:publish', ['--provider' => BlogServiceProvider::class, '--tag' => [BlogServiceProvider::TAGS_PUBLISHED['config.hashids']]]);*/

        $this->publishedFiles();

        $this->organizateConfigHashids($filesystem);

        $this->organizateMigrations($filesystem);

        $this->info("Ejecutando Seeds de configuracion.");

        $this->call('db:seed', ['--class' => 'Codwelt\Blog\Database\Seeds\ConfigSeed']);



    }

    public function publishedFiles()
    {
        $tags = BlogServiceProvider::TAGS_PUBLISHED;
        foreach ($tags as $key => $tag) {
            $this->info("Publicando " . $tag);
            $this->call('vendor:publish', ['--provider' => BlogServiceProvider::class, '--tag' => [$tag]]);
        }
    }



    /**
     * Comprueba que la configuracion del hashids sea la misma de la personalizada si no es asi se reemplaza el archivo de configuracion
     * @param Filesystem $filesystem
     */
    public function organizateConfigHashids(Filesystem $filesystem)
    {
        $this->info("Comprobando Configuracion de hashids.");

        $patchHashIdsConfig = base_path('config/hashids.php');
        $patchMyHashIdsConfig = path_codwelt_blog('Configs/hashids.php');

        if(sha1_file($patchHashIdsConfig) != sha1_file($patchMyHashIdsConfig)){
            $this->info("Reemplazando configuracion de hashids por defecto a personalizada.");
            $myScoutConfig = $filesystem->get($patchHashIdsConfig);
            $filesystem->put(base_path('config/hashids.php'),$myScoutConfig);
        }
    }

    /**
     *
     * @param Filesystem $filesystem
     */
    public function organizateMigrations(Filesystem $filesystem)
    {


        $notest = (bool)$this->option("test");



        //Validar si ya todas las migraciones estan hechas
        $pathMigrations = path_codwelt_blog('Database/Migrations');

        $filesMigration = $filesystem->files($pathMigrations);

        foreach ($filesMigration as $fileMigration){



            $migrationName = explode('.php',$fileMigration->getFilename())[0];
            $register = DB::table('migrations')->where('migration',$migrationName)->first();

            $migracionesExistentes = [];

            if(!is_null($register)){
                //$confirm = $this->confirm("La migracion " . $fileMigration->getFilename() . " ya esta hecha desea eliminarla la tabla y volver a realizarla?");
                array_push($migracionesExistentes,$register);
            }


            if(count($migracionesExistentes) > 0){

                if($notest){
                    $confirm = $this->confirm("Ya existen migraciones, sera necesario eliminar y volver a crear las tablas asi que si desea guardar una configuracion hagalo ahora y confirme para continuar!!");

                    if($confirm){
                        //hacer un rollback
                        $this->info("Eliminando migraciones ya creadas");
                        $this->call('migrate:rollback',['--path' => path_codwelt_blog('Database/Migrations/')]);
                    }else{
                        $this->error("No se realizaran migraciones necesarias para la configuracion.");
                    }
                }


            }


        }


        $this->info("Realizando migraciones de configuracion.");

        $this->call('migrate', ['--path' => path_codwelt_blog('Database/Migrations/')]);
    }


}
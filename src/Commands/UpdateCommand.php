<?php


namespace Codwelt\Blog\Commands;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Database\Seeds\ConfigSeed;
use Codwelt\Blog\Models\Config;
use Illuminate\Console\Command;


/**
 * Class UpdateCommand
 * @package CodWelt\Blog\Commands
 * @author FuriosoJack <iam@furiosojack.com>
 */
class UpdateCommand extends Command
{
    protected $signature = BlogServiceProvider::NAMESPACE_PROYECT.":update";

    protected $description = "Reliaza la actualizacion de la configuracion del paquete";


    public function handle()
    {

        //Se reccoren los datos si no existe se crea
        foreach (ConfigSeed::CONFIGS AS $config){
            if(!Config::exitsThis($config['name'])){
                Config::create($config);
            }
        }
    }
}
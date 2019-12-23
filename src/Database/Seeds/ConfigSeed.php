<?php
namespace Codwelt\Blog\Database\Seeds;

use Codwelt\Blog\Models\Config;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class ConfigSeed
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class ConfigSeed extends Seeder
{

    const CONFIGS = [
                        [
                        'name' => Config::PAGINATION_HOME_ROW,
                        'value' => 10,
                        ],
                        [
                        'name' => Config::PAGINATION_ADMIN_ROW,
                        'value' => 10
                        ],
                        [
                        'name' => Config::PAGINATION_COMMENTS_ROW,
                        'value' => 10
                        ],
                        [
                            'name' => Config::TITLLE_BLOG,
                            'value' => 'Blog CodWelt Package'
                        ],
                        [
                            'name' => Config::DESCRIPTION_BLOG,
                            'value' => 'Paquete blog para laravel hecho por @furiosojack'
                        ],
                        [
                            'name' => Config::KEYWORKS_BLOG,
                            'value' => 'codwelt,laravel,blog'
                        ],
                        [
                            'name' => Config::ROBOTS_PAGES,
                            'value' => '{"home": "index,follow", "search":"noindex,nofollow,nocache,noarchive","post":"index,follow"}'
                        ]

                    ];

    public function run()
    {

        if(Schema::hasTable('blog_config')){
            foreach (self::CONFIGS as $config){
                DB::table('blog_config')->insert($config);
            }
        }else{
            echo "La tabla blog_config no existe, haga las migraciones de la configuracion o realice la instanacion con blogCodWelt:install\n";
        }


    }

}
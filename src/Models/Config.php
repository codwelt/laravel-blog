<?php


namespace Codwelt\Blog\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Config
 * @package CodWelt\Blog\Models
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class Config extends Model
{
    protected $table = "blog_config";

    protected $fillable = ['name', 'value'];


    const PAGINATION_HOME_ROW = "pagination_home";
    const PAGINATION_ADMIN_ROW = "pagination_admin";
    const PAGINATION_COMMENTS_ROW = "pagination_comments_home";
    const TITLLE_BLOG = "title_blog";
    const DESCRIPTION_BLOG = "description_blog";
    const KEYWORKS_BLOG = "keyworks_blog";
    const ROBOTSTXT = "robotsTXT";
    const ROBOTS_PAGES = "robots_pages";


    public static function byName($name)
    {

        return self::where('name',$name)->first();
    }
    /**
     * @return int
     */
    public static function paginationHome()
    {
        $paginacion = self::where('name',self::PAGINATION_HOME_ROW)->first();

        if(is_null($paginacion)){
            /*\LaraException::message("Error de configuracion de paginacion del blog")->details("no existe el registro de paginacion para el home")
                ->withLog()
                ->build();*/
            return 10;
        }
        return $paginacion->value;

    }

    /**
     * @return int
     */
    public static function paginationAdmin()
    {
        $paginacion = self::where('name',self::PAGINATION_ADMIN_ROW)->first();

        if(is_null($paginacion)){
            /*\LaraException::message("Error de configuracion de paginacion del blog")
                ->details("no existe el registro de paginacion para el admin")
                ->withLog()
                ->build();*/
            return 10;
        }
        return $paginacion->value;

    }

    /**
     * @return int
     */
    public static function paginationCommentsHome()
    {
        $paginacion = self::where('name',self::PAGINATION_COMMENTS_ROW)->first();

        if(is_null($paginacion)){
            /*\LaraException::message("Error de configuracion de paginacion del blog")
                ->details("no existe el registro de paginacion para los comentarios del home")
                ->withLog()
                ->build();*/
            return 10;
        }
        return $paginacion->value;

    }

    /**
     * Se encarga de validar si existe una configuracion parasando como parametro el nombre del registro
     * @param $configName
     */
    public static function exitsThis($configName)
    {
        $model = static::byName($configName);
        if(is_null($model)){
            return false;
        }
        return true;

    }

    public static function getRobotsArray()
    {
        $model = static::byName(static::ROBOTS_PAGES);
        return json_decode($model->value,true);
    }


}
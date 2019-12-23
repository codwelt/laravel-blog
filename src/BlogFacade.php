<?php
namespace Codwelt\Blog;

use Illuminate\Support\Facades\Facade;
/**
 * Class Facade
 * @package CodWelt\Blog
 * @author FuriosoJack <iam@furiosojack.com>
 */
class BlogFacade extends Facade
{
    /**
     * Se encarga de retorar la fachada registrada en el service provider
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'CodweltBlog';
    }

}
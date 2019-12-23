<?php


namespace Codwelt\Blog\Operations\Tools;
use Codwelt\Blog\BlogServiceProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class Tools
 * @package CodWelt\Blog\Operations\Tools
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Tools
{


    public static function Page404($exception)
    {

        if($exception instanceof  NotFoundHttpException ){
            if(strpos(request()->getPathInfo(), "blog") !== FALSE){
                return view(BlogServiceProvider::NAMESPACE_PROYECT.'::User.404');
            }
        }

    }

}
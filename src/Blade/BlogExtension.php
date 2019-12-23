<?php


namespace Codwelt\Blog\Blade;
use BitPress\BladeExtension\Contracts\BladeExtension;
use Codwelt\Blog\BlogServiceProvider;
use Illuminate\Support\Facades\Auth;


/**
 * Class BlogExtension
 * @package CodWelt\Blog\Blade
 * @author FuriosoJack <iam@furiosojack.com>
 */
class BlogExtension implements BladeExtension
{

    /**
     * Register directives
     *
     * ```php
     * return [
     *     'truncate' => [$this, 'truncate']
     * ];
     * ```
     *
     * @return array
     */
    public function getDirectives()
    {

        return [

        ];
    }

    /**
     * Register conditional directives
     *
     * ```php
     * return [
     *     'prod' => [$this, 'isProd']
     * ];
     * ```
     *
     * @return array
     */
    public function getConditionals()
    {
        return [
            BlogServiceProvider::NAMESPACE_PROYECT.'_isCommentator' => [$this,'authCommentator']
        ];
    }


    /**
     * Se encarga de validar si el usuario autenticado es comentador para ellos se realiza con el metodo commentator
     * @return bool
     */
    public function authCommentator()
    {
        if(!Auth::guest()){
            if(method_exists(Auth::user(),'commentator')){
                return true;
            }
        }
        return false;
    }







}
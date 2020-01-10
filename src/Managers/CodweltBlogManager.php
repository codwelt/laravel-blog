<?php


namespace Codwelt\Blog\Managers;




use Codwelt\Blog\BlogServiceProvider;

class CodweltBlogManager
{


    /**
     * Devuelve la url del post
     * @param $slug
     * @return string
     */
    public function getUrlPost($slug)
    {
        if(request()->wantsJson()){
            return route(BlogServiceProvider::NAMESPACE_PROYECT . '.api.user.posts.show', ['slug' => $slug]);
        }
        return route(BlogServiceProvider::NAMESPACE_PROYECT.'.show',['slug' =>$slug]);
    }


    /**
     * Devuelve la url del post para encotrarla desde el front
     * @param $slug
     * @return string
     */
    public function getUrlPostMetaTag($slug):string
    {
        if(request()->wantsJson()){
            $front = config(BlogServiceProvider::NAMESPACE_PROYECT . '.api.front.posts');
            return $front . '/'. $slug;
        }
        return route(BlogServiceProvider::NAMESPACE_PROYECT.'.show',['slug' =>$slug]);
    }

    /**
     * Devuelve el dominio del proyecto
     * @return string
     */
    public function getDomainMetaTag():string
    {
        if(request()->wantsJson()){


            return parse_url(config('codwelt_blog.api.front.site'))["host"];
        }
        return parse_url(config('app.url'))["host"];
    }




}
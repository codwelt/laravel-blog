<?php


namespace Codwelt\Blog\Http\Resources;
use Carbon\Carbon;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Models\Config;
use Codwelt\Blog\Operations\Constants\Path;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class PostMiniResource
 * @package CodWelt\Blog\Http\Resources
 * @author FuriosoJack <iam@furiosojack.com>
 */
class PostMiniResource extends JsonResource
{

    public function toArray($request)
    {
        $managetBlog = app('CodweltBlogManager');
        Carbon::setLocale('es');
        $data = [
            'titulo' => $this->titulo,
            'files' => [
                'imgThumbnail' =>  $this->getUrlMiniImage()
            ],
            'autor' => new CreatorResource($this->creador),
            'fecha_publicacion' => $this->created_at->diffForHumans(),
            "resumen" => $this->resumen,
            'url' =>  $managetBlog->getUrlPost($this->slug),
            'slug' => $this->slug,
            'urlRelated' => $this->getUrlRelated(),
            'hashtags' => HashTagResource::collection($this->hashtags),
            "comentarios_total" => $this->comments()->count()
        ];

        return $data;
    }
    public function with($request)
    {

        $managetBlog = app('CodweltBlogManager');
        $myWith = [
            'meta_tags' => [
                "description" => $this->resumen,
                'keyworks' => $this->getMetaKeyWords(),
                'robots' => Config::getRobotsArray()['post'],
                'canonical' => $managetBlog->getUrlPostMetaTag($this->slug),
                "article:author" => $this->creador->getNameModel(),
                "article:published_time" => $this->created_at,
                'og:title' => $this->titulo,
                'og:description' => $this->resumen,
                'og:url' =>  $managetBlog->getUrlPostMetaTag($this->slug),
                'og:type' => 'article',
                'og:locale' => app()->getLocale(),
                'og:site_name' =>  $managetBlog->getDomainMetaTag(),
                'og:image' => $this->getUrlMiniImage(),
                //twitter
                'twitter:title' =>$this->titulo,
                'twitter:description' =>  $this->resumen,
                'twitter:url' => $managetBlog->getUrlPostMetaTag($this->slug),
                'twitter:site' => !empty(config('seotools.twitter.defaults.site'))  ? config('seotools.twitter.defaults.site') : '@codwelt',
                'twitter:images0' => $this->getUrlMiniImage()
            ]
        ];

        return $myWith;
    }

}
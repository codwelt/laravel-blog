<?php


namespace Codwelt\Blog\Operations\SEO;
use Codwelt\Blog\Models\Post;
use Laravelium\Sitemap\Sitemap;


/**
 * Class SitemapBlog
 * @package CodWelt\Blog\Operations\SEO
 * @author FuriosoJack <iam@furiosojack.com>
 */
class SitemapBlog
{

    public static function generate(Sitemap $sitemap)
    {

        $posts = Post::published()->get();

        foreach ($posts as $post){
            $images = [
                [
                    'url' => $post->getUrlMiniImage()
                ]
            ];
            $sitemap->add($post->getUrl(),$post->created_at,'0.90','daily',$images,$post->titulo);

        }

    }

}
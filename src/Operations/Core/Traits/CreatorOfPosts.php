<?php
/**
 * Created by PhpStorm.
 * User: juand
 * Date: 28/06/18
 * Time: 08:58 PM
 */

namespace Codwelt\Blog\Operations\Core\Traits;

use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Models\Post;

trait CreatorOfPosts
{

    public function posts()
    {
        return $this->hasMany(Post::class,'user_id',config(BlogServiceProvider::NAMESPACE_PROYECT.'.creatorPost.columnOfRelation'));
    }

    /**
     * Debe retornar el nombre de quien crea el post
     * @return string
     */
    public abstract function getNameModel();

}
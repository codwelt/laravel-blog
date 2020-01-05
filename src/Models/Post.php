<?php


namespace Codwelt\Blog\Models;

use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Operations\Constants\Path;
use Codwelt\Blog\Operations\Models\StatePost;
use Codwelt\Blog\Operations\Tools\UrlFormater;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class Post
 * @package CodWelt\Blog\Models
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Post extends Model
{
    use SoftDeletes;
    protected $table = "blog_posts";

    const COLUMS = ['titulo','contenido','patch_miniatura','resumen','slug','meta_keywords','state'];

    protected $fillable = self::COLUMS;

    protected $visible = ['titulo','contenido','patch_miniatura','resumen'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function hashtags()
    {
        return $this->belongsToMany(HashTag::class,'blog_post_hashtags','post_id','hashtag_id')->withTimestamps();
    }

    public function fuentes()
    {

        return $this->hasMany(Fuente::class);
    }

    public function creador()
    {
        return $this->belongsTo(config(BlogServiceProvider::NAMESPACE_PROYECT.'.creatorPost.model') ?: config('auth.providers.users.model'),'user_id',config(BlogServiceProvider::NAMESPACE_PROYECT.'.creatorPost.columnOfRelation'));
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id','id');
    }

    public function files()
    {
        return $this->hasMany(File::class,'post_id','id');
    }



    /**
     * Devuelve la url utilizada para ver el detalle del post
     * @return string
     */
    public function getURL()
    {
        return route(BlogServiceProvider::NAMESPACE_PROYECT.'.show',['slug' => $this->slug]);
    }


    /**
     * Obtiene la url de la imagen de miniatura del post
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlMiniImage()
    {
       return  url('storage/'.BlogServiceProvider::NAMESPACE_PROYECT . Path::PUBLIC_STORAGE_POST_IMAGES_THUMBNAIL.'/'.$this->patch_miniatura);
    }


    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlHeaderImage()
    {
        return url('storage/'. BlogServiceProvider::NAMESPACE_PROYECT . Path::PUBLIC_STORAGE_POST_IMAGES_HEADER.'/'.$this->patch_miniatura);
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'posts_index';
    }


    public function toSearchableArray()
    {
        $array = $this->toArray();
        // Customize array...
        $array = ['titulo' => $this->titulo,'contenido' => $this->contenido, 'resumen' => $this->resumen];
        //var_dump($array);
        return $array;

    }



    public function scopeSearch($query,$value)
    {
        return $query->where("titulo","LIKE","%{$value}%")->orWhere("resumen","LIKE","%{$value}%")->orWhere("contenido","LIKE","%{$value}%");
    }

    /**
     * AÑade filtro post publicados
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {

        return $query->where('state',StatePost::PUBLISHED);
    }

    public function scopebyHashTag($query,$name)
    {
        return $query->published()->whereHas('hashtags',function($query) use($name){
            $query->where('nombre','LIKE','%'.$name.'%');
        });
    }

    public function scropeMySearch($query,$data)
    {
        return $query->published();
    }

    /**
     * Hace la busqueda del post por medio de id cifrado
     * @param $id
     * @return mixed
     */
    public static function byEncryptedId($id)
    {
        $decodeID = Hashids::decode($id);
        if (empty($decodeID)) {
            lara_exception('Id invalido, id desconfiado')->style(BlogServiceProvider::NAMESPACE_PROYECT)->build();
        }

        return static::published()->where('id',$decodeID[0])->first();



    }

    public function getEncryptedId()
    {

        return Hashids::encode($this->id);
    }


    public function getUrlRelated()
    {
        return route(BlogServiceProvider::NAMESPACE_PROYECT.'.api.user.posts.related',['postID' => $this->getEncryptedId()]);
    }


}
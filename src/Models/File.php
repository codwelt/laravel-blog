<?php


namespace Codwelt\Blog\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Imagen
 * @package Codwelt\Blog\Models
 * @author FuriosoJack <iam@furiosojack.com>
 */
class File extends Model
{

    protected $table = "blog_files";

    const COLUMS = ['type','path', 'full_path' ,'extension','realname'];


    protected $fillable = self::COLUMS;

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }



}
<?php


namespace Codwelt\Blog\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Comentario
 * @package CodWelt\Blog\Models
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Comment extends Model
{

    protected $table = "blog_comments";

    protected $fillable = ['content','commentator_id'];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function commentator()
    {
        return $this->belongsTo(Commentator::class,'commentator_id','id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }



}
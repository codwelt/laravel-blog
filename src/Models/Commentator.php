<?php


namespace Codwelt\Blog\Models;
use Codwelt\Blog\BlogServiceProvider;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Comentador
 * @package CodWelt\Blog\Models
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Commentator extends Model
{

    protected $table = "blog_commentators";

    protected $fillable = ['email'];

    public function comments()
    {
        return $this->hasMany(Comment::class,'commentator_id','id');
    }

    public function author()
    {
        return $this->belongsTo(config(BlogServiceProvider::NAMESPACE_PROYECT.'.commentatorPost.model') ?: config('auth.providers.users.model'),'model_id',config(BlogServiceProvider::NAMESPACE_PROYECT.'.commentatorPost.columnOfRelation'));
    }

}
<?php


namespace Codwelt\Blog\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Fuente
 * @package CodWelt\Blog\Models
 * @author FuriosoJack <iam@furiosojack.com>
 */
class Fuente extends Model
{
    protected $table = "blog_fuentes";
    protected $fillable = ["fecha_consulta","autor","ano_publicacion","url","titulo","post_id"];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
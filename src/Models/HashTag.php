<?php


namespace Codwelt\Blog\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HasTag
 * @package CodWelt\Blog\Models
 * @author FuriosoJack <iam@furiosojack.com>
 */
class HashTag extends Model
{
    use SoftDeletes;
    protected $table = "blog_hashtags";

    const FILL_NOMBRE = 'nombre';

    protected $fillable = [self::FILL_NOMBRE];

    public function posts()
    {
        return $this->belongsToMany(Post::class,'blog_post_hashtags','hashtag_id','post_id')->withTimestamps();
    }


    //Metodos generales para su funcionamiento del core del blog

    /**
     * @param string $nombre
     */
    public static function exitePorNombre(string $nombre)
    {
        return !is_null(static::porNombre($nombre));
    }

    public static function porNombre(string $nombre)
    {
        return static::where(static::FILL_NOMBRE,$nombre)->first();
    }
}
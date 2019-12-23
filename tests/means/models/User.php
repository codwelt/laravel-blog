<?php


namespace Codwelt\Blog\Tests\means\models;

use Codwelt\Blog\Operations\Core\Traits\CommentatorOfPosts;
use Codwelt\Blog\Operations\Core\Traits\CreatorOfPosts;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * Class User
 * @package Codwelt\Blog\Tests\means\models
 * @author FuriosoJack <iam@furiosojack.com>
 */

class User extends Authenticatable
{
    use Notifiable;
    use CreatorOfPosts;
    use CommentatorOfPosts;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'remember_token',
    ];


    /**
     * Correo electronico que se mostrara en los comentarios
     * @return string
     */
    public function getEmailModel()
    {
        return $this->email;
    }

    /**
     * Debe retornar el nombre de quien crea el post
     * @return string
     */
    public function getNameModel()
    {
        return $this->name;
    }
}
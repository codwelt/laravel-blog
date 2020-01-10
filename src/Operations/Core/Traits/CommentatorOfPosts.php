<?php


namespace Codwelt\Blog\Operations\Core\Traits;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Models\Commentator;
use Vinkla\Hashids\Facades\Hashids;


/**
 * Class CommentatorOfPosts
 * @package CodWelt\Blog\Operations\Core\Traits
 * @author FuriosoJack <iam@furiosojack.com>
 */
trait CommentatorOfPosts
{

    /**
     * Devuelve el modelo commentador que es su representacion
     * @return mixed
     */
    public function commentator()
    {
        return $this->hasOne(Commentator::class,'model_id',config(BlogServiceProvider::NAMESPACE_PROYECT.'.commentatorPost.columnOfRelation'));
    }

    /**
     * Se encarga de obtener el id cifrado del commentador en el caso de que el modelo que es comentador
     * no tiene comentador se le crea
     * @return mixed
     */
    public function getCommentatorIDEncrypted()
    {
        if(is_null($this->commentator)){
            $commentator = $this->commentator()->create([
                'email' => $this->getEmailModel()
            ]);

            return Hashids::encode($commentator->id);
        }
        return Hashids::encode($this->commentator->id);
    }

    /**
     * Debe retornar el nombre que se mostrara en los comentarios
     * @return string
     */
    public abstract function getNameModel();

    /**
     * Correo electronico que se mostrara en los comentarios
     * @return string
     */
    public abstract function getEmailModel();


    /**
     *  Debe retornar la url de la foto de perfil del usuario, si se retorna nulo se asigna una foto por defecto
     * @return mixed
     */
    public abstract function getUrlImageProfile();


}
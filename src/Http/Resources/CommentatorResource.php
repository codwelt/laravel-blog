<?php


namespace Codwelt\Blog\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class CommentatorResource
 * @package CodWelt\Blog\Http\Resources
 * @author FuriosoJack <iam@furiosojack.com>
 */
class CommentatorResource extends JsonResource
{

    public function toArray($request)
    {
        $nombre = 'Anonimo';

        if(!is_null($this->author)){
            $nombre = $this->author->getNameModel();
        }

        return [
          'email' => $this->email,
          'nombre' => $nombre
        ];
    }

}
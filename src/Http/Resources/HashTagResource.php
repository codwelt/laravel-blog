<?php


namespace Codwelt\Blog\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class TagResource
 * @package CodWelt\Blog\Http\Resources
 * @author FuriosoJack <iam@furiosojack.com>
 */
class HashTagResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'nombre' =>ucfirst($this->nombre),
            'nPosts' => $this->posts()->count()
        ];
    }

}
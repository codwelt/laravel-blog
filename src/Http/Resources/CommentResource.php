<?php


namespace Codwelt\Blog\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class CommentResource
 * @package CodWelt\Blog\Http\Resources
 * @author FuriosoJack <iam@furiosojack.com>
 */
class CommentResource extends JsonResource
{

    public function toArray($request)
    {
        Carbon::setLocale('es');
        return [
            'contenido' => $this->content,
            'comentador' => new CommentatorResource($this->commentator),
            'fecha_creacion' => $this->created_at->diffForHumans()
        ];
    }

}
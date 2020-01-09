<?php


namespace Codwelt\Blog\Http\Resources;
use Carbon\Carbon;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Operations\Constants\Path;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * Class PostMiniResource
 * @package CodWelt\Blog\Http\Resources
 * @author FuriosoJack <iam@furiosojack.com>
 */
class PostMiniResource extends JsonResource
{

    public function toArray($request)
    {
        Carbon::setLocale('es');
        $data = [
            'titulo' => $this->titulo,
            'files' => [
                'imgThumbnail' =>  $this->getUrlMiniImage()
            ],
            'autor' => new CreatorResource($this->creador),
            'fecha_publicacion' => $this->created_at->diffForHumans(),
            "resumen" => $this->resumen,
            'url' => $this->getURL(),
            'slug' => $this->slug,
            'urlRelated' => $this->getUrlRelated(),
            'hashtags' => HashTagResource::collection($this->hashtags),
            "comentarios_total" => $this->comments()->count()
        ];

        return $data;
    }

}
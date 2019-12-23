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
                [
                    'key' => 'imgThumbnail',
                    'src' => $this->getUrlMiniImage()
                ]
            ],
            'fecha_publicacion' => $this->created_at->diffForHumans(),
            'url' => $this->getURL(),
            'urlRelated' => $this->getUrlRelated()
        ];

        return $data;
    }

}
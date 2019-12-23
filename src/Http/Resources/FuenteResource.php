<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 27/06/2018
 * Time: 08:21 AM
 */

namespace Codwelt\Blog\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class FuenteResource
 * @package CodWelt\Blog\Http\Resources
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class FuenteResource extends JsonResource
{

   public function toArray($request)
    {
        return [
            'titulo' => $this->titulo,
            'fecha_consulta' => $this->fecha_consulta,
            'autor' => $this->autor,
            'año_publicacion' => $this->ano_publicacion,
            'url' => $this->url
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Juan
 * Date: 27/06/2018
 * Time: 10:22 AM
 */

namespace Codwelt\Blog\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package CodWelt\Blog\Http\Resources
 * @author Juan Diaz - FuriosoJack <iam@furiosojack.com>
 */
class CreatorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->getNameModel()
        ];

    }

}
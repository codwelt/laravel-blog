<?php


namespace Codwelt\Blog\Http\Controllers\User;
use Codwelt\Blog\Http\Controllers\Controller;
use Codwelt\Blog\Http\Resources\HashTagResource;
use Codwelt\Blog\Models\HashTag;
use Codwelt\Blog\Operations\Models\StatePost;


/**
 * Class HashTagsController
 * @package CodWelt\Blog\Http\Controllers\User
 * @author FuriosoJack <iam@furiosojack.com>
 */
class HashTagsJsonController extends Controller
{

    public function index()
    {

        //Hastags cuando los post este publicados
        $hashtags = HashTag::whereHas('posts',function($query){
            $query->where('state',StatePost::PUBLISHED);
        })->get();
        $hastahsResource = HashTagResource::collection($hashtags);

        return response()->json($hastahsResource);

    }
}
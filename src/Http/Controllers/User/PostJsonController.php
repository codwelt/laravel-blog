<?php


namespace Codwelt\Blog\Http\Controllers\User;
use Codwelt\Blog\Http\Controllers\Controller;
use Codwelt\Blog\Http\Resources\PostMiniResource;
use Codwelt\Blog\Http\Resources\PostResource;
use Codwelt\Blog\Models\Config;
use Codwelt\Blog\Models\Post;
use Codwelt\Blog\Operations\Models\StatePost;
use Illuminate\Http\Request;


/**
 * Class PostJsonController
 * @package CodWelt\Blog\Http\Controllers\User
 * @author FuriosoJack <iam@furiosojack.com>
 */
class PostJsonController extends Controller
{

    public function index(Request $request)
    {

        $npagination = Config::paginationHome();

        //Busqueda Normal por titulo
        if($request->has('query')){
            $postPagination = Post::search($request->get('query'))->where('state',StatePost::PUBLISHED)->paginate($npagination);
        }else {
            //Busqueda por tags
            if($request->has('byHashTag')){
                $postPagination = Post::byHashTag($request->get('byHashTag'))->paginate($npagination)->appends('byHashTag', $request->get('byHashTag'));
            }else{
                if($request->has('output')){
                    $postPagination = Post::inRandomOrder()->published()->paginate($npagination)->appends('output', $request->get('output'));
                }else{
                    $postPagination = Post::published()->paginate($npagination);
                }
            }
        }




        $postsCollection = PostResource::collection($postPagination);
        $posts = $postsCollection->response()->getData(true);
        return response()->json($posts);

    }

    public function related(Request $request, $postID)
    {

        $post = Post::byEncryptedId($postID);

        if(!is_null($post)){

            //Obtener 1 post aleatorio de cada uno de los hastahs del post relacionado e
            // ir llenado el array con el tamaño asignado asignado de los post que se van a obtener

            $totalARelacionar = 5;
            $postsRelacionados = collect();
            foreach ($post->hashtags as $hashtag){
                if($totalARelacionar > 0){
                    //Se obtiene el id de los ya relacionados
                    $relacionadosIdArray = $postsRelacionados->pluck('id')->toArray();
                    array_push($relacionadosIdArray,$post->id);


                    //Se obtiene un post cuando no sea uno de los que ya estan relacionados
                    //y cuando los hashtag sea el mismo
                    $whereData = [];

                    foreach ($relacionadosIdArray as $relacionado){
                        array_push($whereData,['id','<>',$relacionado]);
                    }
                    $postRelated = Post::published()->inRandomOrder()
                        ->where($whereData)
                        ->whereHas('hashtags',function($query) use($hashtag){
                            $query->where('id',$hashtag->id);
                        })->first();

                    //Se añade solo cuando ecuentra alguno
                    if(!is_null($postRelated)){
                        //Esto puede pasar cuando hay pocos post y no existe otro post diferente con el que se desea relacionar
                        $postsRelacionados->push($postRelated);
                        $totalARelacionar--;
                    }

                }
            }

            $postCollection = PostMiniResource::collection($postsRelacionados);

            $postsArray = $postCollection->response()->getData(true);

            return response()->json($postsArray);


        }
        return response()->json(['data' => []]);


    }
}
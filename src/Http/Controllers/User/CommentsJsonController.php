<?php


namespace Codwelt\Blog\Http\Controllers\User;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Http\Controllers\Controller;
use Codwelt\Blog\Http\Requests\Users\StoreComment;
use Codwelt\Blog\Http\Resources\CommentResource;
use Codwelt\Blog\Models\Comment;
use Codwelt\Blog\Models\Commentator;
use Codwelt\Blog\Models\Config;
use Codwelt\Blog\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vinkla\Hashids\Facades\Hashids;


/**
 * Class CommentsController
 * @package CodWelt\Blog\Http\Controllers\User
 * @author FuriosoJack <iam@furiosojack.com>
 */
class CommentsJsonController extends Controller
{


    public function store(StoreComment $request)
    {
        $decodeID = Hashids::decode($request->get('postID')) ?: [''];

        $post = Post::find($decodeID[0]);

        if(is_null($post)){
            lara_exception("Post No existe")->style(BlogServiceProvider::NAMESPACE_PROYECT)->build();
        }

        if($request->has('commentatorID')){
            $decodeCommentatorID = Hashids::decode($request->get('commentatorID')) ?: [''];


            $commentator = Commentator::find($decodeCommentatorID[0]);

            if(is_null($commentator)){
                \LaraException::message('Commentator no existe')->build();
            }
        }else{
            //Como ya se sabe por el request que no esta presente el commetatorid lo que significa que si debe estar presente el email

            //Se busca si ya existe un commentor con ese correo
            $commentator = Commentator::where('email',$request->get('email'))->first();

            if(is_null($commentator)){
                //AL no existir se crea

                $commentator = Commentator::create([
                    'email' => $request->get('email')
                ]);
            }

        }



        $post->comments()->create([
            'content' => $request->get('content'),
            'commentator_id' => $commentator->id
        ]);

        return response()->json(['response'  => true]);


    }



    public function search(Request $request)
    {

        if($request->has('byPostID')){

            $decodeID = Hashids::decode($request->get('byPostID')) ?: [''];


            $ncomments = Config::paginationCommentsHome();

            $commentsModels = Comment::whereHas('post',function($query) use($decodeID){
                $query->where('id',$decodeID[0]);
            })->orderBy('created_at','asc')->paginate($ncomments)->appends('byPostID',$request->get('byPostID'));



            $commentsResource = CommentResource::collection($commentsModels);

            $comments = $commentsResource->response()->getData(true);

            return response()->json($comments);
        }

        return response()->json(['data' => []]);


    }

}
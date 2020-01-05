<?php


namespace Codwelt\Blog\Http\Controllers\User;
use Artesaos\SEOTools\Traits\SEOTools;
use Carbon\Carbon;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Http\Controllers\Controller;
use Codwelt\Blog\Http\Resources\PostResource;
use Codwelt\Blog\Models\Config;
use Codwelt\Blog\Models\HashTag;
use Codwelt\Blog\Models\Post;
use Codwelt\Blog\Operations\Constants\ExcepcionConstants;
use Codwelt\Blog\Operations\Models\StatePost;
use Illuminate\Http\Request;


/**
 * Class PostController
 * @package CodWelt\Blog\Http\Controllers\User
 * @author FuriosoJack <iam@furiosojack.com>
 */
class PostController extends Controller
{
    use SEOTools;
    const KEY_REQUEST_SEARCH = "query";

    public function index(Request $request)
    {



        $npagination = Config::paginationHome();

        //Busqueda Normal por titulo
        if ($request->has(self::KEY_REQUEST_SEARCH)) {

            $postPagination = Post::search($request->get(self::KEY_REQUEST_SEARCH))->where('state',StatePost::PUBLISHED)->paginate($npagination);
        } else {
            //Busqueda por tags
            if ($request->has('byHashTag')) {
                $postPagination = Post::byHashTag($request->get('byHashTag'))->paginate($npagination)->appends('byHashTag', $request->get('byHashTag'));
            } else {
                $postPagination = Post::published()->paginate($npagination);
            }
        }


        $postsCollection = PostResource::collection($postPagination);


        //////////////////////////////////////////////////////////////
        ////////////////////////////// SEO //////////////////////////
        ////////////////////////////////////////////////////////////

        $tagsArray = HashTag::all()->pluck('nombre')->toArray();
        $metaKeyWordsPosts = $postPagination->pluck('meta_keywords')->toArray();

        //Se convierten en array los nuevo keywords y se extraen
        foreach ($metaKeyWordsPosts as $meta){
            $nuevosKeys =  explode(',',$meta);
            $tagsArray = array_merge($nuevosKeys,$tagsArray);
        }


        $titleBlog = Config::byName(Config::TITLLE_BLOG)->value;
        $descriptionBlog = Config::byName(Config::DESCRIPTION_BLOG)->value;


        //Se hace array de los keywokrs que se añade y de los hastags que existen
        $keyWorks = explode(',',Config::byName(Config::KEYWORKS_BLOG)->value);

        $tagsArray = array_merge($tagsArray, $keyWorks);


        $this->seo()->setTitle($titleBlog);
        $this->seo()->setDescription($descriptionBlog);
        $this->seo()->setCanonical(request()->url());

        if($request->has('query')){
            $this->seo()->metatags()->addMeta('robots',Config::getRobotsArray()['search']);
        }else{
            $this->seo()->metatags()->addMeta('robots',Config::getRobotsArray()['home']);
        }


        //Metas Adicionales


        //$this->seo()->metatags()->addMeta('article:author','codwelt');
        for($i = 0; $i < count($tagsArray); $i++){
            $this->seo()->metatags()->addMeta('article:tag',$tagsArray[$i],'tag'.$i);
        }

        //$this->seo()->metatags()->addMeta("google","notranslate"); //ara prevenir que Google tradusca tu página al idioma del usuario.


        //Meta
        $this->seo()->metatags()->setTitle($titleBlog);
        $this->seo()->metatags()->setDescription($descriptionBlog);
        $this->seo()->metatags()->setCanonical(request()->url());
        $this->seo()->metatags()->setKeywords(implode(',',$tagsArray));



        //Opengraph
        $this->seo()->opengraph()->setTitle($titleBlog);
        $this->seo()->opengraph()->setDescription($descriptionBlog);
        $this->seo()->opengraph()->setUrl(request()->url());
        $this->seo()->opengraph()->addProperty('type', 'website');
        $this->seo()->opengraph()->addProperty('updated_time',Carbon::now()->toDateTimeString());
        //$this->seo()->opengraph()->addImage($logoBlog);





        //Twitter
        $this->seo()->twitter()->setTitle($titleBlog);
        $this->seo()->twitter()->setDescription($descriptionBlog);
        $this->seo()->twitter()->setUrl(request()->url());
        //$this->seo()->twitter()->setSite('@codwelt');
     //   $this->seo()->twitter()->addValue('image',$logoBlog);
        //$this->seo()->twitter()->addValue('creator','@furiosojack');

        //////////////////////////////////////////////////////////////
        ///////////////////////////FIN SEO //////////////////////////
        ////////////////////////////////////////////////////////////
        ///
        ///
        $posts = $postsCollection->response()->getData(true);

        //debugMe($posts);

        return view(BlogServiceProvider::NAMESPACE_PROYECT.'::User.lista_posts',[
            'resourceData' => $posts
        ]);

    }


    public function show(Request $request,$slug)
    {

        $post = Post::where('slug',$slug)->where('state', StatePost::PUBLISHED)->first();

        if(is_null($post)){
            return response()->view(BlogServiceProvider::NAMESPACE_PROYECT. "::User.404",[],404);
        }


        //////////////////////////////////////////////////////////////
        ////////////////////////////// SEO //////////////////////////
        ////////////////////////////////////////////////////////////

        $tagsArray = $post->hashtags->pluck('nombre')->toArray();
        $tagsArray = array_merge($tagsArray,explode(',',$post->meta_keywords));

        $this->seo()->setTitle($post->titulo);
        $this->seo()->setDescription($post->resumen);
        $this->seo()->setCanonical($post->getURL());

        $this->seo()->metatags()->addMeta('robots',Config::getRobotsArray()['post']);

        //Metas Adicionales

        $this->seo()->metatags()->addMeta('article:author',$post->creador->getNameModel());

        foreach ($tagsArray as $tag){
            $this->seo()->metatags()->addMeta('article:tag',$tag);
        }

        $this->seo()->metatags()->addMeta('article:published_time',$post->created_at);



        //Meta
        $this->seo()->metatags()->setTitle($post->titulo);
        $this->seo()->metatags()->setDescription($post->resumen);
        $this->seo()->metatags()->setCanonical($post->getURL());
        $this->seo()->metatags()->setKeywords(implode(',',$tagsArray));



        //Opengraph
        $this->seo()->opengraph()->setTitle($post->titulo);
        $this->seo()->opengraph()->setDescription($post->resumen);
        $this->seo()->opengraph()->setUrl($post->getURL());
        $this->seo()->opengraph()->addProperty('type', 'article');
        $this->seo()->opengraph()->addProperty('locale',app()->getLocale());
        $this->seo()->opengraph()->addProperty('updated_time',$post->updated_at);
        $this->seo()->opengraph()->addImage($post->getUrlHeaderImage());




        //Twitter
        $this->seo()->twitter()->setTitle($post->titulo);
        $this->seo()->twitter()->setDescription($post->resumen);
        $this->seo()->twitter()->setUrl($post->getURL());
        $this->seo()->twitter()->setSite('@codwelt');
        $this->seo()->twitter()->addValue('image',$post->getUrlHeaderImage());
        $this->seo()->twitter()->addValue('creator','@furiosojack');

        //////////////////////////////////////////////////////////////
        ///////////////////////////FIN SEO //////////////////////////
        ////////////////////////////////////////////////////////////

        $postResource = (new PostResource($post))->response()->getData(true);

        // debugMe($postResource);
        return view(BlogServiceProvider::NAMESPACE_PROYECT.'::User.detalle_post',[
            'post' => $postResource
        ]);

    }


}
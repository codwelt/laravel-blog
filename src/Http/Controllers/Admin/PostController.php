<?php


namespace Codwelt\Blog\Http\Controllers\Admin;
use Codwelt\Blog\BlogServiceProvider;
use Codwelt\Blog\Http\Controllers\Controller;
use Codwelt\Blog\Http\Requests\Admin\StorePostRequest;
use Codwelt\Blog\Http\Requests\Admin\UpdatePostRequest;
use Codwelt\Blog\Http\Resources\PostResource;
use Codwelt\Blog\Models\Config;
use Codwelt\Blog\Models\Fuente;
use Codwelt\Blog\Models\HashTag;
use Codwelt\Blog\Models\Post;
use Codwelt\Blog\Operations\Constants\ExcepcionConstants;
use Codwelt\Blog\Operations\Constants\Path;
use Codwelt\Blog\Operations\Models\StatePost;
use Codwelt\Blog\Operations\Structures\ImagePost;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vinkla\Hashids\Facades\Hashids;


/**
 * Class PostController
 * @package CodWelt\Blog\Controllers
 * @author FuriosoJack <iam@furiosojack.com>
 */
class PostController extends Controller
{

    /**
     * Se encarga de recorrer todos los hastag pasados y si no existe se crea y todos se alamacenan en una coleccion que sera la
     * que el post necesitara para asociarse
     * @param array $hastagsArray
     * @return Collection
     */
    private function corrobrarHashtags(array $hashtagsArray)
    {
        //La coleccion de hastags
        $hashtags = new Collection();
        foreach ($hashtagsArray as $hashtagArray) {

            $hashtag = HashTag::porNombre($hashtagArray['nombre']);

            if (is_null($hashtag)) {
                //Se crea el nuevo Hashtag
                $hashtag = HashTag::create([
                    HashTag::FILL_NOMBRE => $hashtagArray['nombre']
                ]);
            }

            $hashtags->push($hashtag);

        }

        return $hashtags;


    }


    /**
     * Muestra vista para crear post
     */
    public function index()
    {
        $postsCollection = PostResource::collection(Post::paginate(Config::paginationAdmin()));
        $posts = $postsCollection->response()->getData(true);
        return view(BlogServiceProvider::NAMESPACE_PROYECT . '::Admin.Posts.index', ['posts' => $posts]);

    }


    /**
     * Metodo para retornar la vista para crear
     */
    public function create()
    {

        return view(BlogServiceProvider::NAMESPACE_PROYECT . '::Admin.Posts.crear');
    }



    private function checkFileInStorage(string $fileName):bool
    {

        $file1 = Storage::disk('public')->exists(BlogServiceProvider::NAMESPACE_PROYECT .'/'.Path::PUBLIC_STORAGE_POST_IMAGES_HEADER . '/'.$fileName);

        $file2 = Storage::disk('public')->exists(BlogServiceProvider::NAMESPACE_PROYECT .'/'. Path::PUBLIC_STORAGE_POST_IMAGES_THUMBNAIL . '/'.$fileName);

        return $file1 && $file2;
    }


    /**
     * Metodo para crear post
     */
    public function store(StorePostRequest $request)
    {

        $imagenName = Str::random(10);

        switch ($request->get('state')) {

            case StatePost::PUBLISHED:

                $imageStructure = new ImagePost($request->file('imagen'),$imagenName);
                $imageStructure->save();
                $imagenName = $imageStructure->getNameInfStorage();

                $contenido = $request->get('contenido');
                $resumen = $request->get('resumen');
                $meta_keywords = $request->get('meta_keywords');
                $statePost = StatePost::PUBLISHED;
                $hashtags = $request->get('hashtags');
                $fuentes = is_null($request->get('fuentes')) ? [] : $request->get('fuentes');

                break;

            default:
                //Borrador


                if ($request->has('imagen')) {
                    $requestFile = $request->file('imagen');

                    $imageStructure = new ImagePost($requestFile,$imagenName);
                    $imageStructure->save();
                    $imagenName = $imageStructure->getNameInfStorage();
                }

                $contenido = '';
                $resumen = '';
                $meta_keywords = '';
                $statePost = StatePost::DRAFT;
                $hashtags = [];
                $fuentes = [];

                if (!is_null($request->get('contenido'))) {
                    $contenido = $request->get('contenido');
                }

                if (!is_null($request->get('resumen'))) {
                    $resumen = $request->get('resumen');
                }

                if (!is_null($request->get('meta_keywords'))) {
                    $meta_keywords = $request->get('meta_keywords');
                }

                if (!is_null($request->get('hashtags'))) {
                    $hashtags = $request->get('hashtags');
                }

                if (!is_null($request->get('fuentes'))) {
                    $fuentes = $request->get('fuentes');
                }

                break;

        }

        //Se espera que el usuario autenticado sea creados de posts
        $post = Auth::user()->posts()->create([
            'titulo' => $request->get('titulo'),
            'contenido' => $contenido,
            'patch_miniatura' => $imagenName, //Se almacena el nombre de la imagen
            'resumen' => $resumen,
            'slug' => $request->get('slug'),
            'meta_keywords' => $meta_keywords,
            'state' => $statePost
        ]);


        foreach ($this->corrobrarHashtags($hashtags) as $hashtag) {
            $hashtag->posts()->attach($post);
        }


        foreach ($fuentes as $fuente) {
            $post->fuentes()->create([
                'autor' => $fuente['autor'],
                'fecha_consulta' => $fuente['fecha_consulta'],
                'ano_publicacion' => $fuente['ano_publicacion'],
                'url' => $fuente['url'],
                'titulo' => $fuente['titulo']
            ]);
        }




        return redirect()->route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.');

    }

    public function edit(Request $request, $postID)
    {

        $decodeID = Hashids::decode($postID);

        if (empty($decodeID)) {
            return response()->json(["message" => "Post NO existe"], 404);
        }

        $post = Post::find($decodeID[0]);

        if (is_null($post)) {
            return redirect()->route(BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.');
        }



        $postResource = (new PostResource($post))->response()->getData(true);


        return view(BlogServiceProvider::NAMESPACE_PROYECT . '::Admin.Posts.editar', ['post' => $postResource['data']]);

    }





    /***
     * Metodod para actualizar post
     */
    public function update(UpdatePostRequest $request, $postID)
    {

        $decodeID = Hashids::decode($postID);

        if (empty($decodeID)) {
            lara_exception(ExcepcionConstants::POST_NOT_FOUNT)->debugCode(16)->style(BlogServiceProvider::NAMESPACE_PROYECT)->build(404);
        }

        $post = Post::find($decodeID[0]);

        if(is_null($post)){
            return redirect()->route('blog.admin.posts.');
        }

        //Se obtiene la informacion que enviaron
        $informacionActualizar = $request->only(Post::COLUMS);

        //Se genera un nombre de imagen por si se necesita
        $imagenName = helperman_random_string(10);

        switch ($request->get('state')){
            case StatePost::PUBLISHED:

                $statePost = StatePost::PUBLISHED;

                $fuentes = [];
                $hashtags = [];

                //Obtengo lo hastags para ver si toca actualizar o añadir

                if($request->has('hashtags')){
                    $hashtags = $request->get('hashtags');
                }else{
                    //Comrpobar que tenga almenos un hashtag
                    if($post->hashtags->count() < 1){
                        return redirect()->back()->withErrors('Hace falta asingar almenos un hashtag al post')->withInput();
                    }

                }

                if($request->has('fuentes')){
                    $fuentes = $request->get('fuentes');
                }

                //COmporbar que tenga una imagen que exista
                if($request->has('imagen')){

                    //Se sube la nueva imagen
                    $imagenStructure = new ImagePost($request->file('imagen'), $imagenName);
                    $imagenStructure->save();
                    $imagenName = $imagenStructure->getNameInfStorage();

                    /////////////////Verificar si el path imagen anctual exise una imagen para borrala
                    ///
                    ///
                    ///

                    $informacionActualizar['patch_miniatura'] = $imagenName;


                }else{

                    $imagenName = $post->patch_miniatura;
                    if($this->checkFileInStorage($imagenName)){
                        unset($informacionActualizar['patch_miniatura']);
                    }else{
                        return redirect()->back()->withErrors('Hace falta asignarle una imagen al post.')->withInput();
                    }
                }

                break;
            default:
                if($request->has('imagen')){
                    //Se sube la nueva imagen


                    $imagenStructure = new ImagePost($request->file('imagen'),$imagenName);
                    $imagenStructure->save();
                    $imagenName = $imagenStructure->getNameInfStorage();

                    /////////////////Verificar si el path imagen anctual exise una imagen para borrala
                    ///
                    ///
                    ///

                    $informacionActualizar['patch_miniatura'] = $imagenName;
                }

                $informacionActualizar['contenido'] = '';
                $informacionActualizar['resumen'] = '';
                $informacionActualizar['meta_keywords'] = '';
                $informacionActualizar['state'] = StatePost::DRAFT;
                $hashtags = [];
                $fuentes = [];

                if(!is_null($request->get('contenido'))){
                    $informacionActualizar['contenido'] = $request->get('contenido');
                }

                if(!is_null($request->get('resumen'))){
                    $informacionActualizar['resumen'] = $request->get('resumen');
                }

                if(!is_null($request->get('meta_keywords'))){
                    $informacionActualizar['meta_keywords'] =  $request->get('meta_keywords');
                }

                if(!is_null($request->get('hashtags'))){
                    $hashtags = $request->get('hashtags');
                }

                if(!is_null($request->get('fuentes'))){
                    $fuentes = $request->get('fuentes');
                }

                break;

        }


        $hashtagsModel = $this->corrobrarHashtags($hashtags);

        //Añador los que ya tiene

        $hashtagsCurrent = $hashtagsModel->merge($post->hashtags);

        $hashtagsIDs = $hashtagsCurrent->pluck('id')->toArray();
        //Se sincronizan los hashtags
        $post->hashtags()->sync($hashtagsIDs);



        $post->update($informacionActualizar);        //$post->save();

        //SI envian fuentes
        if(count($fuentes) > 0 ){
            $post->fuentes()->delete(); //Se eliminan todas las fuentes

            //Se crean las nuevas fuentes
            foreach ($request->get('fuentes') as $fuente){
                $post->fuentes()->create([
                    'autor' => $fuente['autor'],
                    'fecha_consulta' => $fuente['fecha_consulta'],
                    'ano_publicacion' => $fuente['ano_publicacion'],
                    'url' => $fuente['url'],
                    'titulo' => $fuente['titulo']
                ]);
            }
        }



        return redirect()->back();


    }

    /**
     * Metodo para eliminar post
     */
    public function destroy($postID)
    {
        $decodeID = Hashids::decode($postID);

        if (empty($decodeID)) {
            lara_exception('Post no existe.')->debugCode(16)->style(BlogServiceProvider::NAMESPACE_PROYECT)->build(404);
        }

        $post = Post::find($decodeID[0]);

        if (!is_null($post)) {
            $post->delete();
        }
        return redirect()->back();
    }


}
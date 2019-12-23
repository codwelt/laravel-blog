<?php


namespace Codwelt\Blog\Http\Requests\Admin;

use Codwelt\Blog\Operations\Models\StatePost;
use Illuminate\Foundation\Http\FormRequest;
/**
 * Class StorePost
 * @package CodWelt\Blog\Http\Requests
 * @author FuriosoJack <iam@furiosojack.com>
 */
class StorePostRequest extends FormRequest
{
    const REGEX_TITULO = '^[A-Za-z \-_.!ñÑáéíóúÁÉÍÓÚ¡?¿,&%$+*()#@0-9]*$';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        $reglas = [
            'imagen' => [
                'image',
                'mimetypes:image/png,image/jpeg',
                'dimensions:min_width=100,min_height=100'],//'max_width=4096,max_height=2304|max:1000',
            'titulo' => [
                'required',
                'string',
                'regex:/'.self::REGEX_TITULO.'/',
                'unique:blog_posts,titulo'
            ],
            'slug' => [
                'required',
                'string',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
            ],

            'fuentes.*' => 'array',
            'fuentes.*.autor' => [
                'required_with:fuentes',
                'string',
                'regex:/'.self::REGEX_TITULO.'/'
            ],
            'fuentes.*.ano_publicacion' => 'required_with:fuentes|date_format:Y|before_or_equal:today',
            'fuentes.*.fecha_consulta' => [
                'required_with:fuentes',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:' . \Carbon\Carbon::createFromDate($this->get('fuentes.*.ano_publicacion'),1,1)->format('Y-m-d'),
                'before_or_equal:today',

            ],
            //'fuentes.*.url' => 'url',
            'fuentes.*.titulo' => [
                'required_with:fuentes',
                'string',
                'regex:/'.self::REGEX_TITULO.'/'
            ],
            'hashtags' => ['array'],
            'hashtags.*' => ['array'],
            'hashtags.*.nombre' => ['alpha_num'],
            'state' => [
                'regex:/^('.StatePost::PUBLISHED.'||'.StatePost::DRAFT.')$/'
            ]
        ];


        switch ($this->get('state')){
            case StatePost::PUBLISHED:
                $masReglas = [
                    'imagen' => ['required'],
                    'contenido' => [
                        'string',
                        'required',
                        'unique:blog_posts,contenido'
                    ],
                    'resumen' => [
                        'required',
                        'string',
                        //'regex:/'.self::REGEX_TITULO.'/',
                        'max:400'
                    ],
                    'meta_keywords' => [
                        'required',
                        'string',
                        'regex:/^[a-z0-9,A-Z]+$/'
                    ],
                    'hashtags' => ['required'],
                    'hashtags.*' => ['required'],
                    'hashtags.*.nombre' => ['required'],
                ];
                $reglas = array_merge($reglas, $masReglas);
                break;
            default:
                break;
        }
        return $reglas;
    }

    public function messages()
    {
        return [
            'title.regex' => 'El titulo no comple lo requerimientos '
        ];
    }
}
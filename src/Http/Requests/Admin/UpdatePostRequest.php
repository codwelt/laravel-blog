<?php


namespace Codwelt\Blog\Http\Requests\Admin;
use Codwelt\Blog\Operations\Models\StatePost;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdatePostRequest
 * @package CodWelt\Blog\Http\Requests
 * @author FuriosoJack <iam@furiosojack.com>
 */
class UpdatePostRequest extends FormRequest
{

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
                'dimensions:min_width=100,min_height=100'
            ],//'max_width=4096,max_height=2304|max:1000',
            'titulo' => [
                'string',
                'regex:/'.StorePostRequest::REGEX_TITULO.'/',
            ],
            'slug' => [
                'string',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
            ],
            'fuentes.*' => 'array',
            'fuentes.*.autor' => [
                'required_with:fuentes',
                'string',
                'regex:/'.StorePostRequest::REGEX_TITULO.'/'
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
                'regex:/'.StorePostRequest::REGEX_TITULO.'/'
            ],
            'hashtags' => ['array'],
            'hashtags.*' => ['required_with:hashtags','alpha_num'],
            'state' => [
                'regex:/^('.StatePost::PUBLISHED.'||'.StatePost::DRAFT.')$/'
            ]
        ];


        switch ($this->get('state')){
            case StatePost::PUBLISHED:
                $masReglas = [
                    'titulo' => [
                        'required'
                    ],
                    'slug' => ['required'],
                    'contenido' => [
                        'string',
                        'required'
                    ],
                    'resumen' => [
                       // 'regex:/'.StorePostRequest::REGEX_TITULO.'/',
                        'max:400'
                    ],
                    'meta_keywords' => [
                        'required',
                        'string',
                        'regex:/^[a-z0-9,A-Z]+$/'
                    ]

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
            'title.regex' => 'El titulo no comple lo requerimientos'
        ];
    }

}
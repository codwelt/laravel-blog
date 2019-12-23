<?php


namespace Codwelt\Blog\Http\Requests\Users;
use Illuminate\Foundation\Http\FormRequest;


/**
 * Class StoreComment
 * @package CodWelt\Blog\Http\Requests\Users
 * @author FuriosoJack <iam@furiosojack.com>
 */
class StoreComment extends FormRequest
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
        return [
            'postID' => 'required|string|size:10',
            'content' => 'required|string',
            'commentatorID' => 'required_without:email|string|size:10',
            'email' => 'required_without:commentatorID|email'
        ];

    }

}
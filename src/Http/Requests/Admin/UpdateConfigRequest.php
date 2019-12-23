<?php


namespace Codwelt\Blog\Http\Requests\Admin;
use Codwelt\Blog\Models\Config;
use Codwelt\Blog\Operations\Validation\ConfigRobotPost;
use Illuminate\Foundation\Http\FormRequest;


/**
 * Class UpdateConfigRequest
 * @package CodWelt\Blog\Http\Requests\Admin
 * @author FuriosoJack <iam@furiosojack.com>
 */
class UpdateConfigRequest extends FormRequest
{

     const RULES =  [
         Config::PAGINATION_HOME_ROW => "integer",
         Config::PAGINATION_ADMIN_ROW => "integer",
         Config::PAGINATION_COMMENTS_ROW => "integer",
         Config::ROBOTS_PAGES => ["json"],
         Config::KEYWORKS_BLOG => "string|min:3",
         Config::TITLLE_BLOG => "string|max:80|min:10",
         Config::DESCRIPTION_BLOG => "string|max:320|min:80"
     ];

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
        $rules = self::RULES;
        array_push($rules[Config::ROBOTS_PAGES],new ConfigRobotPost());
        return $rules;
    }
}
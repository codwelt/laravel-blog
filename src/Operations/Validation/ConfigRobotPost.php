<?php


namespace Codwelt\Blog\Operations\Validation;
use Illuminate\Contracts\Validation\Rule;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
/**
 * Class ConfigRobotPost
 * @package CodWelt\Blog\Operations\Validation
 * @author FuriosoJack <iam@furiosojack.com>
 */
class ConfigRobotPost implements Rule
{

    private $validadorJsonSHEMA;


    public function __construct()
    {
        $this->validadorJsonSHEMA = new Validator();

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {




        $data = (object)json_decode($value);

        $this->validadorJsonSHEMA->validate($data,(object)[
            'type' => 'object',
            'required' => [
                'home',
                'search',
                'post'
            ],
            'propierties' => (object)[
                'home' => (object)[
                    'type' => 'string'
                ],
                'search' => (object)[
                    'type' => 'string'
                ],
                'post' => (object)[
                    'type' => 'string'
                ]

            ]

        ],Constraint::CHECK_MODE_COERCE_TYPES);

        return $this->validadorJsonSHEMA->isValid();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $filterMessage = array_map(function($error){
            return $error['message'];
        },$this->validadorJsonSHEMA->getErrors());
        return implode("," ,$filterMessage);
    }
}
<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Log;

/**
 * Class NoneBedSelected
 *
 * @package App\Rules
 */
class NoneBedSelected implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $params;

	/**
	 * NoneBedSelected constructor.
	 *
	 * @param $params
	 */
	public function __construct($params)
    {
        //
	    $this->params = $params;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
	    $input = request()->all();
	    $parameters = $this->params;

		foreach ($parameters as $key => $val) {
			if((int)array_get($input, $val) > 0) {
				return true;
			}
		}
		if((int)$value > 0 ) return true;
		return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '';
    }
}

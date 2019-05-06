<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\UsersPhoneNumbers;
use Propaganistas\LaravelPhone\PhoneNumber;
use Log;

/**
 * Class UniquePhoneNumber
 *
 * @package App\Rules
 */
class UniquePhoneNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $params;

	/**
	 * UniquePhoneNumber constructor.
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

		$phone_number = PhoneNumber::make($value, $input['phone_code'])->formatE164();

		if(count($parameters) == 0) {
			$parameters[0] = null; // handle exception when $parameters no exist
		}
		$duplicated = UsersPhoneNumbers::where('phone_number', $phone_number)
						->where('id', '!=', $parameters[0])
						->first();
		if($duplicated) {
			return false;
		} else {
			return true;
		}
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Phone Number has already been taken.';
    }
}

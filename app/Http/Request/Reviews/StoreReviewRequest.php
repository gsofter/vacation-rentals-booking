<?php

namespace App\Http\Requests\Reviews;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Log;

/**
 * Class StoreReviewRequest
 *
 * @package App\Http\Requests\Reviews
 */
class StoreReviewRequest extends FormRequest
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
			'accuracy'    => 'integer',
			'accuracy_comments'    => 'max:1200',
			'amenities'    => 'integer',
			'amenities_comments'    => 'max:1200',
			'checkin'    => 'integer',
			'checkin_comments'    => 'max:1200',
			'cleanliness'    => 'integer',
			'cleanliness_comments'    => 'max:1200',
			'comments'    => 'required|max:1200',
			'communication'    => 'integer',
			'communication_comments'    => 'max:1200',
			'improve_comments'    => 'max:1200',
			'location'    => 'integer',
			'location_comments'    => 'max:1200',
			'love_comments'    => 'max:1200',
			'private_feedback'    => 'max:1200',
			'rating'    => 'integer',
			'recommend'    => 'integer',
			'reservation_id' => 'integer',
			'respect_house_rules'    => 'integer',
			'room_id'    => 'required|integer',
			'user_from'    => 'required|integer',
			'user_to'    => 'required|integer',
			'value'    => 'integer',
			'value_comments'    => 'max:1200',
		];
	}

	/**
	 * Return validation error
	 * @param \Illuminate\Contracts\Validation\Validator $validator
	 *
	 * @throws \Illuminate\Http\Exceptions\HttpResponseException
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json($validator->errors(), 422));
	}
}

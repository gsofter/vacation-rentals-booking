<?php

namespace App\Traits;

/**
 * Trait ModelHelpers
 *
 * @package App\Traits
 */
trait ModelHelpers
{
	/**
	 * Returns empty string if value is a null, the value otherwise.
	 *
	 * @param $value
	 * @return mixed
	 */
	public function nullToEmpty($value)
	{
		return $value ?? '';
	}

	/**
	 * Returns zero if value is an empty string, the value otherwise.
	 *
	 * @param $value
	 * @return mixed
	 */
	public function emptyToZero($value)
	{
		return $value !== '' ? $value : 0;
	}
}
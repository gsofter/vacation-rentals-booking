<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Front\User;

/**
 * App\Models\PropertyManager
 *
 * @property int $id
 * @property string $email
 * @property string $access_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $first_name
 * @property-read mixed $last_name
 * @property-read mixed $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyManager whereAccessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyManager whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyManager whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property mixed|string $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyManager whereUserId($value)
 */
class PropertyManager extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'property_manager';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 'access_code'];

	protected $appends = ['first_name','last_name','status', 'user_id'];

	////todo-vr Still working on creating this relationship.
	//	public function user(){
	//		return $this->hasOne( 'App\Models\Front\User', 'user_id', 'id');
	//	}

	/**
	 * Get User First Name
	 * @return mixed|string
	 */
	public function getFirstNameAttribute()
	{
		$user = User::where('email',$this->attributes['email'])->first();
		if($user)
			return $user->first_name;
		else
			return '';
	}

	/**
	 * Get User Last Name
	 * @return mixed|string
	 */
	public function getLastNameAttribute()
	{
		$user = User::where('email',$this->attributes['email'])->first();
		if($user)
			return $user->last_name;
		else
			return '';
	}

	/**
	 * Get User Status
	 * @return mixed|string
	 */
	public function getStatusAttribute()
	{
		$user = User::where('email',$this->attributes['email'])->first();
		if($user)
			return $user->status;
		else
			return '';
	}

	/**
	 * Get User ID
	 * @return mixed|string
	 */
	public function getUserIdAttribute(){
		$user = User::where('email',$this->attributes['email'])->first();
		if($user)
			return $user->id;
		else
			return '';

	}
}

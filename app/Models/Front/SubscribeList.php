<?php

/**
 * Subscription Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Subscription
 * @author      Trioangle Product Team
 * @version     1.1
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SubscribeList
 *
 * @property int $id
 * @property int $room_id
 * @property int $host_id
 * @property int $amount
 * @property string $currency_code
 * @property int $subscription_days
 * @property string $subscription_start_date
 * @property string $subscription_end_date
 * @property string $stripe_customer_id
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Front\Currency $currency
 * @property-read \App\Models\Front\Rooms $rooms
 * @property-read \App\Models\Front\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereHostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereStripeCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereSubscriptionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereSubscriptionEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereSubscriptionStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $braintree_plan
 * @property string|null $braintree_id
 * @property string|null $ends_at
 * @property string|null $trial_ends_at
 * @property int|null $quantity
 * @property string|null $stripe_plan
 * @property string|null $stripe_id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereBraintreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereBraintreePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereStripePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SubscribeList whereTrialEndsAt($value)
 */
class SubscribeList extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'subscribe_list';

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'trial_ends_at', 'ends_at',
		'created_at', 'updated_at',
	];

	// Join with rooms table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
	{
		return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
	}
	// Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
	{
		return $this->belongsTo('App\Models\Front\User','host_id','id');
	}
	// Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
	{
		return $this->belongsTo('App\Models\Front\Currency','currency_code','code');
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public static function getUserSubscriptionRooms(){

		$ids = SubscribeList::join('rooms', 'rooms.id' , '=', 'subscribe_list.room_id')
		                    ->where('rooms.user_id', \Auth::user()->id)
		                    ->where(function ($query){
			                    $query->where('subscribe_list.ends_at', '>=', now())
			                          ->orWhereNull('subscribe_list.ends_at');
		                    })->get(['subscribe_list.id' ])->toArray();

		return SubscribeList::whereIn('id' , $ids)->where('status', '!=', 'Free')->get();
	}

}

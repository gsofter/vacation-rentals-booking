<?php

/**
 * Reviews Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Reviews
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Session;
use App\Models\Front\User;
use Tymon\JWTAuth\JWTAuth;

/**
 * App\Models\Reviews
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $room_id
 * @property string $list_type
 * @property int $user_from
 * @property int $user_to
 * @property string $review_by
 * @property string $comments
 * @property string $private_feedback
 * @property string $love_comments
 * @property string $improve_comments
 * @property int $rating
 * @property int $accuracy
 * @property string $accuracy_comments
 * @property int $cleanliness
 * @property string $cleanliness_comments
 * @property int $checkin
 * @property string $checkin_comments
 * @property int $amenities
 * @property string $amenities_comments
 * @property int $communication
 * @property string $communication_comments
 * @property int $location
 * @property string $location_comments
 * @property int $value
 * @property string $value_comments
 * @property int $respect_house_rules
 * @property int $recommend
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $date_fy
 * @property-read mixed $hidden_review
 * @property-read \App\Models\Front\Reservation $reservation
 * @property-read \App\Models\Front\User $users
 * @property-read \App\Models\Front\User $users_from
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereAccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereAccuracyComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereAmenities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereAmenitiesComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCheckin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCheckinComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCleanliness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCleanlinessComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCommunicationComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereImproveComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereListType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereLocationComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereLoveComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews wherePrivateFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereRespectHouseRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereReviewBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereUserFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereUserTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereValueComments($value)
 * @mixin \Eloquent
 * @property string $status
 * @property-read string $accuracy_html_rating
 * @property-read string $ammenities_html_rating
 * @property-read string $checkin_html_rating
 * @property-read string $cleanliness_html_rating
 * @property-read string $communication_html_rating
 * @property-read string $location_html_rating
 * @property-read string $overall_html_rating
 * @property-read string $value_html_rating
 * @property-read \App\Models\Front\Rooms $rooms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reviews whereStatus($value)
 */
class Reviews extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reviews';
	protected $appends =['date_fy'];
	protected $guarded = ['id'];
	// Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
	{
		return $this->belongsTo( User::class,'user_to','id');
	}

	// Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users_from()
	{
		return $this->belongsTo( User::class,'user_from','id');
	}

	// Join with reservation table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reservation()
	{
		return $this->belongsTo( Reservation::class,'reservation_id','id');
	}

	/**
	 * Join with Rooms table
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
	{
		return $this->belongsTo( Rooms::class,'room_id','id');
	}

	/**
	 * Scope a query to only include active reviews.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query->where('status', '=','Active')->get();
	}

	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	public function hasReservation() {
		if($this->attributes['reservation_id']) {
			return true;
		}
		return false;
	}

	// Get updated_at date in fy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getDateFyAttribute()
	{
		// return date('F Y', strtotime($this->attributes['updated_at']));
		return date(env('PHP_DATE_FORMAT'), strtotime($this->attributes['updated_at']));
	}

	/**
	 * Check give record is Hidden review or not
	 * @return bool
	 */
	public function getHiddenReviewAttribute()
	{
		$reservation_id = $this->attributes['reservation_id'];
		$user_from = $this->attributes['user_from'];
		$user_to = $this->attributes['user_to'];
		$check = $this->where(['user_from'=>$user_to, 'user_to'=>$user_from, 'reservation_id'=>$reservation_id])->get();
		if($check->count()) {
			return false;
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function getOverallHtmlRatingAttribute()
	{
		$rating = $this->attributes['rating'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Ammenities Reviews Star Rating
	 * @return string
	 */
	public function getAmmenitiesHtmlRatingAttribute()
	{
		$rating = $this->attributes['ammenities'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Accuracy Reviews Star Rating
	 * @return string
	 */
	public function getAccuracyHtmlRatingAttribute()
	{
		$rating = $this->attributes['accuracy'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Communication Reviews Star Rating
	 * @return string
	 */
	public function getCommunicationHtmlRatingAttribute()
	{
		$rating = $this->attributes['communication'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Checkin Reviews Star Rating
	 * @return string
	 */
	public function getCheckinHtmlRatingAttribute()
	{
		$rating = $this->attributes['checkin'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Cleanliness Reviews Star Rating
	 * @return string
	 */
	public function getCleanlinessHtmlRatingAttribute()
	{
		$rating = $this->attributes['cleanliness'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Location Reviews Star Rating
	 * @return string
	 */
	public function getLocationHtmlRatingAttribute()
	{
		$rating = $this->attributes['location'];

		return $this->ratingHtml($rating);
	}

	/**
	 * Value Reviews Star Rating
	 * @return string
	 */
	public function getValueHtmlRatingAttribute()
	{
		$rating = $this->attributes['value'];

		return $this->ratingHtml( $rating);

	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCreatedAtAttribute(){
		return date(env('PHP_DATE_FORMAT').' H:i:s',strtotime($this->attributes['created_at']));
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getUpdatedAtAttribute(){
		return date(env('PHP_DATE_FORMAT').' H:i:s',strtotime($this->attributes['updated_at']));
	}

	/**
	 * Generate review star rating html
	 * @param $rating
	 *
	 * @return string
	 */
	public function ratingHtml($rating) {
		$html  = '<div class="star-rating"> <div class="foreground">';

		if($rating)
		{
			$whole = floor($rating);
			$fraction = $rating - $whole;

			for($i=0; $i<$whole; $i++) {
				$html .= ' <i class="icon icon-beach icon-star"></i>';
			}

			if($fraction >= 0.5) {
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';
			}
		}

		$html .= ' </div> <div class="background mb_blck">';
		$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
		$html .= ' </div> </div>';
		return $html;
	}
}

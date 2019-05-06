<?php

/**
 * Rooms Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Rooms
 */

namespace App\Models\Front;

use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use DateTime;
use DateTimeZone;
use Config;
use Session;
use App\Models\Front\User;
use App\Models\Front\RoomType;
use App\Models\Front\RoomsAddress;
use App\Models\Front\Subscription;
use App\Models\Front\RoomsPhotos;
use App\Models\Front\SubscribeList;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\JWTAuth;
use Request;
use Log;
// use Laravel\Cashier\Billable;


use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use App\Models\Front\Reviews;
use Arcanedev\SeoHelper\Traits\Seoable;
/**
 * Class Rooms
 *
 * @package App\Models
 */

/**
 * App\Models\Front\Rooms
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $sub_name
 * @property string $summary
 * @property string $check_in_time
 * @property string $check_out_time
 * @property string $booking_message
 * @property int $plan_type
 * @property int $property_type
 * @property int $room_type
 * @property string $is_shared
 * @property int|null $accommodates
 * @property int|null $bedrooms
 * @property int|null $beds
 * @property int|null $bed_type
 * @property float|null $bathrooms
 * @property string|null $amenities
 * @property string $video
 * @property string|null $calendar_type
 * @property string|null $booking_type
 * @property string $cancel_policy
 * @property string|null $cancel_message
 * @property string $popular
 * @property string $started
 * @property string $recommended
 * @property int $views_count
 * @property int $subscription_days
 * @property string $subscription_start_date
 * @property string $subscription_end_date
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string|null $stripe_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property string|null $braintree_id
 * @property string|null $paypal_email
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\RoomsAvailabilityRules[] $availability_rules
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Calendar[] $calendar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Calendar[] $calendar_data
 * @property-read mixed $accuracy_star_rating
 * @property-read mixed $address_url
 * @property-read mixed $approved_status
 * @property-read mixed $banner_photo_name
 * @property-read mixed $bed_type_name
 * @property-read mixed $checkin_star_rating
 * @property-read mixed $cleanliness_star_rating
 * @property-read mixed $communication_star_rating
 * @property-read mixed $created_time
 * @property-read mixed $host_name
 * @property-read mixed $host_name_first
 * @property-read mixed $host_name_last
 * @property-read int $image_upload_count
 * @property-read mixed $link
 * @property-read mixed $location_star_rating
 * @property-read mixed $overall_star_rating
 * @property-read mixed $photo_name
 * @property-read mixed $plan_type_name
 * @property-read mixed $property_type_name
 * @property-read mixed $reviews_count
 * @property-read mixed $room_created_at
 * @property-read mixed $room_type_name
 * @property-read mixed $room_updated_at
 * @property-read mixed $slug
 * @property-read mixed $src
 * @property-read mixed $steps_count
 * @property-read mixed $value_star_rating
 * @property-read \App\Models\Subscription $planType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\RoomsPriceRules[] $price_rules
 * @property-read \App\Models\RoomType $room_type_data
 * @property-read \App\Models\Front\RoomsAddress $rooms_address
 * @property-read \App\Models\Front\RoomsDescription $rooms_description
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\RoomsPhotos[] $rooms_photos
 * @property-read \App\Models\Front\RoomsPrice $rooms_price
 * @property-read \App\Models\SavedWishlists $saved_wishlists
 * @property-read \App\Models\SubscribeList $subscribe_list
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereAccommodates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereAmenities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBookingMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBookingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereBraintreeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCalendarType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCancelMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCancelPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCardBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCardLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCheckInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCheckOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereIsShared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms wherePaypalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms wherePlanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms wherePopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms wherePropertyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereRecommended($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereRoomType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereStarted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereSubName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereSubscriptionDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereSubscriptionEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereSubscriptionStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Rooms whereViewsCount($value)
 */

class Rooms extends Model {
	use Sluggable;
	// use SluggableScopeHelpers;
	use Seoable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	// use Billable;

	protected $table = 'rooms';

	protected $fillable = ['summary', 'name', 'braintree_id', 'paypal_email', 'card_brand', 'card_last_four', 'trial_ends_at','bedrooms','bathrooms'];

	protected $appends = [
		'steps_count',
//		'property_type_name',
//		'room_type_name',
//		'bed_type_name',
		'photo_name',
//		'host_name',
//		'host_name_first',
//		'host_name_last',
//		'host_id',
//		'reviews_count',
//		'overall_star_rating',
		//				'subscribe_list_id',
		'address_url',
//		'plan_type_name',
		'has_subscription',
		'approved_status',
		'featured_image',
		'featured_image_small',
		'featured_image_small',
		// 'search_listing_photos_image_name'

	];

	protected $dates = ['deleted_at'];

	protected $casts = [
		'approved_status' => 'boolean',
		'seo'             => 'array'
	];

	/**
	 * Sluggable configuration.
	 *
	 * @var array
	 * @return array
	 */
	public function sluggable() {
		return [
			'slug' => [
				'source' => [ 'rooms_address.city', 'rooms_address.state', 'bedroom_url', 'bathroom_url', 'property_type_name' ],
				'unique' => false,
			]
		];
	}

	/**
	 * Slugify rule to exclude apostrophes
	/**
	 * @param \Cocur\Slugify\Slugify $engine
	 * @param string $attribute
	 * @return \Cocur\Slugify\Slugify
	 */

	public function customizeSlugEngine(Slugify $engine, $attribute) {
		$engine->addRule('\'', '');
		return $engine;
	}

	//Setters

	/**
	 * @param $input
	 */
	//	public function setSummaryAttribute($input){
	//				$this->attributes['summary'] = Helpers::stripNonAllowedTags($input);
	//	}

	/**
	 * @param $input
	 */
	// public function setNameAttribute($input){
	// 	$this->attributes['name'] = Helpers::sanitizeString($input);
	// }

	/**
	 * @param $input
	 */
	public function setRoomTypeAttribute($input) {
		$room_type = RoomType::where('id', $input)->first();
		$is_shared = @$room_type->is_shared == 'Yes' ? 'Yes' : 'No';
		$this->attributes['room_type'] = $input;
		$this->attributes['is_shared'] = $is_shared;
	}

	// Join with room_tags table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function room_tags()
	{
		return $this->belongsToMany(RoomTag::class, 'room_tag', 'room_id','tag_id');
	}

	// Check rooms table user_id is equal to current logged in user id
	/**
	 * Check rooms table user_id is equal to current logged in user id
	 * @param $id
	 *
	 * @return \App\Models\Front\Rooms|\Illuminate\Database\Eloquent\Model|null|object
	 */
	public static function check_user($id)
	{
		 $room = Rooms::where(['id' => $id, 'user_id' => @Auth::user()->id])->first();
		 if($room){
			$room->room_description = $room->rooms_description()->first();

		 }
		return $room;
	}

	// Join with rooms_address table

	/**
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms_address()
	{
		return $this->belongsTo('App\Models\Front\RoomsAddress','id','room_id');
	}

	// Join with rooms_price table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms_price()
	{
		return $this->belongsTo('App\Models\Front\RoomsPrice','id','room_id');
	}

	// Join with rooms_price table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function room_type_data()
	{
		return $this->belongsTo('App\Models\RoomType','room_type','id');
	}

	// Join with  subscription table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function plan_type()
	{
		return $this->belongsTo('App\Models\Subscription','plan_type','id');
	}

	// Join with rooms_description table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms_description()
	{
		return $this->belongsTo('App\Models\Front\RoomsDescription','id','room_id');
	}

	// Join with saved_wishlists table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function saved_wishlists()
	{
		return $this->belongsTo('App\Models\SavedWishlists','id','room_id');
	}

	//Join with sunscribe_list table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function subscribe_list()
	{
		return $this->belongsTo('App\Models\Front\SubscribeList','id','room_id');
	}


	// Join with reviews table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function reviews()
	{
		return $this->hasMany('App\Models\Front\Reviews','room_id','id')->where('user_to', $this->attributes['user_id'])->where('list_type', 'Rooms');;
	}

	//Get rooms photo all

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function rooms_photos()
	{
		return $this->hasMany('App\Models\Front\RoomsPhotos', 'room_id', 'id');

	}

	// Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
	{
		return $this->belongsTo('App\Models\Front\User','user_id','id');
	}

	// Join with calendar table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function calendar()
	{
		// return $this->hasMany('App\Models\Front\Calendar','room_id','id');
		return $this->hasMany('App\Models\Front\Calendar', 'room_id', 'id')
		            ->where('status', 'Not available');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function calendar_data()
	{
		return $this->hasMany('App\Models\Front\Calendar', 'room_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function roomsApprovedStatus() {
		return $this->belongsTo( 'App\Models\RoomsApprovedStatus', 'room_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function price_rules() {
		return $this->hasMany('App\Models\Front\RoomsPriceRules', 'room_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function availability_rules() {
		return $this->hasMany('App\Models\Front\RoomsAvailabilityRules', 'room_id', 'id');
	}

	//Scopes

	/**
	 * Scope a query to only include listings of a given status
	 *
	 * @param $query
	 *
	 * @param $status
	 *
	 * @return mixed
	 */
	public function scopeStatus($query, $status) {
		return $query->where('status', $status);
	}

	/**
	 * Scope with 'Listed' status
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeListed($query)
	{
		return $query->whereStatus('Listed');
	}

	/**
	 * Scope with 'Unlisted' status
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeUnlisted($query)
	{
		return $query->whereStatus('Unlisted');
	}

	/**
	 * Scope with 'Draft' status
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeDraft($query)
	{
		return $query->whereStatus('Draft');
	}

	/**
	 * Scope recommended listings
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeRecommended($query)
	{
		return $query->whereRecommended('Yes');
	}

	/**
	 * Scope popular listings
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopePopular($query)
	{
		return $query->wherePopular('Yes');
	}

	/**
	 * Scope by state
	 * @param $query
	 * @param $state
	 *
	 * @return mixed
	 */
	public function scopeState($query, $state)
	{
		return $query->whereHas('rooms_address',function($query) use($state){
			$query->whereState($state);
		});
	}

	/**
	 * Scope by city
	 * @param $query
	 * @param $city
	 *
	 * @return mixed
	 */
	public function scopeCity($query, $city)
	{
		return $query->whereHas('rooms_address',function($query) use($city){
			$query->whereCity($city);
		});
	}

	/**
	 * Scope by city
	 * @param $query
	 * @param $city
	 *
	 * @return mixed
	 */
	public function scopeCountry($query, $country)
	{
		$country = Country::whereLongName($country)->first();
		return $query->whereHas('rooms_address',function($query) use($country){
			$query->whereCountry($country->short_name);
		});
	}

	/**
	 * Scope a query to get host user data
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeUser($query)
	{
		return $query->where('user_id', '=', Auth::user()->id);
	}

	/**
	 * Has recommended listing
	 * @return bool
	 */
	public function hasRecommended() {
		if($this->recommended == 'Yes') {
			return true;
		}
		return false;
	}

	/**
	 * Has popular listing
	 *
	 * @return bool
	 */
	public function hasPopular() {
		if ( $this->popular == 'Yes' ) {
			return true;
		}

		return false;
	}


	/**
	 * Get image count based on plan ID
	 * @param $planId
	 * @return mixed return image number
	 */
	public static function getPlanImageCount($planId) {
		$imageCount = Subscription::where('id', $planId)->first()->images;
		return $imageCount;
	}

	/**
	 * Get Subscription ID
	 * @return mixed
	 *
	 */
	//    public function getSubscriptionIdAttribute() {
	//		$room = Rooms::find($this->attributes['id']);
	//		return $this->subscribe_list->id;
	//	}

	/**
	 * Get image upload count
	 * @return int image count
	 */
	public function getImageUploadCountAttribute()
	{
		$room = Rooms::find($this->attributes['id']);
		// Default count
		$upload_count = 35;
		if($room)
		{
			$upload_count = $this->getPlanImageCount($room->plan_type);

		}
		return $upload_count;
	}
	public function getHasSubscriptionAttribute (){
		return  Rooms::find($this->attributes['id'])->hasActiveSubscription();
	}
	/**
	 * Get address url
	 * @deprecated  use sluggable trait instead
	 * @return string
	 */
	public function getAddressUrlAttribute()
	{
		//		$room = Rooms::find($this->attributes['id']);
		//		$address = str_slug(@$room->rooms_address->city,'-').'-'.str_slug(@$room->rooms_address->state,'-').'-'.str_slug(@$room->name,'-');
		//		return $address;
		return $this->slug;
	}

	/**
	 * @return string
	 */
	public function getBathroomUrlAttribute() {
		if($this->hasBathroomCount()) {
			return $this->bathrooms . ' ' . trans_choice('messages.rooms.bathroom', 1);
		}
		return '1 bathroom';
	}

	/**
	 * @return string
	 */
	public function getBedroomUrlAttribute() {
		if($this->hasBedroomCount()) {
			return $this->bedrooms . ' ' . trans_choice('messages.rooms.bedroom', 1);
		}
		return '1 bedroom';
	}

	/**
	 * Checks if listting has bathrooms count
	 * @return bool
	 */
	public function hasBathroomCount() {
		if(isset($this->bathrooms)) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if listting has bedrooms count
	 * @return bool
	 */
	public function hasBedroomCount() {
		if(isset($this->bedrooms)) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if listting has a name
	 * @return bool
	 */
	public function hasName() {
		if (isset($this->name)) {
			return true;
		}
		return false;
	}


	/**
	 * Checks if an active subscription exists for model
	 * @return bool
	 */
	public function hasActiveSubscription() {
		$paymentSubscriptions = SubscribeList::where('room_id', $this->id)->get();
		$currentDate = date("Y-m-d");
		if(count($paymentSubscriptions) >0) {
			foreach ( $paymentSubscriptions as $paymentSubscription ) {
				if ( $paymentSubscription->stripe_id && $paymentSubscription->stripe_id != '' ) {
					 \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
					 $subscription = null;
					 $error = false;
					 try{
						$subscription = \Stripe\Subscription::retrieve($paymentSubscription->stripe_id);
					 }
					 catch(\Stripe\Error\InvalidRequest $e){
						$error = true;
						continue ;
					 }
					 if(!$error){

						$timestamp    = $subscription->current_period_end;
						if ( $timestamp > strtotime( $currentDate ) ) {
							return true;
							exit;
						}
					 }
					 
					 
					// $timestamp    = strtotime( $paymentSubscription->subscription_end_date );
					// if ( $timestamp > strtotime( $currentDate ) ) {
					// 			return true;
					// 			exit;
					// 		}
				} 
				elseif( $paymentSubscription->braintree_id && $paymentSubscription->braintree_id != '' ){
					$timestamp    = strtotime( $paymentSubscription->subscription_end_date );
					if ( $timestamp > strtotime( $currentDate ) ) {
								return true;
								exit;
							}
				}
				else{
					$timestamp    = strtotime( $paymentSubscription->subscription_end_date );
					if ( $timestamp > strtotime( $currentDate ) ) {
								return true;
								exit;
							}
				}
				// elseif( $paymentSubscription->braintree_id && $paymentSubscription->braintree_id != '' ) {
				// 	$subscription = \Braintree_Subscription::find( $paymentSubscription->braintree_id );
				// 	$timestamp    = strtotime( $subscription->billingPeriodEndDate->format( 'Y-m-d' ) );
				// 	if ( $timestamp > strtotime( $currentDate ) ) {
				// 		return true;
				// 		exit;
				// 	}
				// }

			}
		}
		else{
			$timestamp    = strtotime( $this->subscription_end_date );
			if ( $timestamp > strtotime( $currentDate ) ) {
						return true;
						exit;
					}
		}
		return false;
	}

	/**
	 * Get paid subscriptions
	 * @return \App\Models\SubscribeList|\Illuminate\Database\Eloquent\Model|null|object
	 */
	public function paymentSubscription(){
		$subscription = SubscribeList::where('room_id', $this->id)->where('status', '!=', 'Free')->first();
		return $subscription;
	}

	/**
	 * get featured image url
	 * @return mixed
	 */
	public function getFeaturedImageAttribute()
	{
		//check if featured image is set & return it
		if($this->hasFeaturedImage()) {
			return $image = RoomsPhotos::whereRoomId($this->attributes['id'])->whereFeatured('Yes')->first()->name;
			return optional($image)->name;
		}

		//if no featured image is set, just return the first image
		  $image = RoomsPhotos::whereRoomId($this->attributes['id'])->first();
		return optional($image)->name;
	}

	public function getSearchListingPhotosImageNameAttribute(){
		if($this->hasFeaturedImage()) {
			return $image = RoomsPhotos::whereRoomId($this->attributes['id'])->whereFeatured('Yes')->first()->search_listing_photos_image_name;
			return optional($image)->name;
		}
	}
	public function getFeaturedImageSmallAttribute()
	{
		//check if featured image is set & return it
		if($this->hasFeaturedImage()) {
			$image = RoomsPhotos::whereRoomId($this->attributes['id'])->whereFeatured('Yes')->first();
			return optional($image)->manage_listing_photos_image_name;
		}

		//if no featured image is set, just return the first image
		$image = RoomsPhotos::whereRoomId($this->attributes['id'])->first();
		return optional($image)->manage_listing_photos_image_name;
	}

	/**
	 * get large featured image url
	 * @return mixed
	 */
	public function getFeaturedImageLargeAttribute()
	{
		//check if featured image is set & return it
		if($this->hasFeaturedImage()) {
			$image = RoomsPhotos::whereRoomId($this->attributes['id'])->whereFeatured('Yes')->first();
			return optional($image)->slider_image_name;
		}

		//if no featured image is set, just return the first image
		$image = RoomsPhotos::whereRoomId($this->attributes['id'])->first();
		return optional($image)->slider_image_name;
	}

	/**
	 * Check if featured image is set
	 * @return bool
	 */
	public function hasFeaturedImage() {
		$image = RoomsPhotos::whereRoomId($this->attributes['id'])->whereFeatured('Yes')->first();
		if($image) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if listting has a state
	 * @return bool
	 */
	public function hasState() {
		if(isset($this->rooms_address->state)) {
			return true;
		}
		return false;
	}

	/**
	 * Checks if listting has city
	 * @return bool
	 */
	public function hasCity() {
		if(isset($this->rooms_address->city)) {
			return true;
		}
		return false;
	}


	// Reviews Count

	/**
	 * @return int
	 */
	public function getReviewsCountAttribute()
	{
		$reviews = Reviews::whereStatus('Active')->where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id'])->where('list_type', 'Rooms');;

		return $reviews->count();
	}

	// Overall Reviews Star Rating

	/**
	 * @return string
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function getOverallStarRatingAttribute()
	{
		//get current url
		/*$route=@Route::getCurrentRoute();

		if($route)
		{
			$api_url = @$route->getPath();
		}
		else
		{
			$api_url = '';
		}

		 $url_array=explode('/',$api_url);
			//Api currency conversion
		  if(@$url_array['0']=='api')*/
		if(request()->segment(1) == 'api')
		{
			$user_details = JWTAuth::parseToken()->authenticate();
			//get review details
			$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

			if($reviews->count()==0)

			{
				$result['rating_value']='0';
			}

			else
			{
				$result['rating_value']= @($reviews->sum('rating') / $reviews->count());

			}

			$result_wishlist=SavedWishlists::with('wishlists')->where('room_id',$this->attributes['id'])->where('user_id',$user_details->id);

			if($result_wishlist->count() == 0)

				$result['is_wishlist']="No";

			else

				$result['is_wishlist']="Yes";

			return $result;

		}
		else
		{

			$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

			$average = @($reviews->sum('rating') / $reviews->count());

			if($average)
			{
				$html  = '<div class="star-rating"> <div class="foreground">';

				$whole = floor($average);
				$fraction = $average - $whole;

				for ( $i = 0; $i < $whole; $i ++ ) {
					$html .= ' <i class="icon icon-beach icon-star"></i>';
				}

				if ( $fraction >= 0.5 ) {
					$html .= ' <i class="icon icon-beach icon-star-half"></i>';
				}

				$html .= ' </div> <div class="background mb_blck">';
				$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
				$html .= ' </div> </div>';
				return $html;
			}
			else
				return '';
		}
	}

	/**
	 * Accuracy Reviews Star Rating
	 * @return string
	 */
	public function getAccuracyStarRatingAttribute()
	{
		$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

		$average = @($reviews->sum('accuracy') / $reviews->count());

		if($average)
		{
			$html  = '<div class="star-rating"> <div class="foreground">';

			$whole = floor($average);
			$fraction = $average - $whole;

			for($i=0; $i<$whole; $i++)
				$html .= ' <i class="icon icon-beach icon-star"></i>';

			if($fraction >= 0.5)
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';

			$html .= ' </div> <div class="background mb_blck">';
			$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
			$html .= ' </div> </div>';
			return $html;
		}
		else
			return '';
	}

	/**
	 * Location Reviews Star Rating
	 * @return string
	 */
	public function getLocationStarRatingAttribute()
	{
		$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

		$average = @($reviews->sum('location') / $reviews->count());

		if($average)
		{
			$html  = '<div class="star-rating"> <div class="foreground">';

			$whole = floor($average);
			$fraction = $average - $whole;

			for($i=0; $i<$whole; $i++)
				$html .= ' <i class="icon icon-beach icon-star"></i>';

			if($fraction >= 0.5)
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';

			$html .= ' </div> <div class="background mb_blck">';
			$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
			$html .= ' </div> </div>';
			return $html;
		}
		else
			return '';
	}

	/**
	 * Communication Reviews Star Rating
	 * @return string
	 */
	public function getCommunicationStarRatingAttribute()
	{
		$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

		$average = @($reviews->sum('communication') / $reviews->count());

		if($average)
		{
			$html  = '<div class="star-rating"> <div class="foreground">';

			$whole = floor($average);
			$fraction = $average - $whole;

			for($i=0; $i<$whole; $i++)
				$html .= ' <i class="icon icon-beach icon-star"></i>';

			if($fraction >= 0.5)
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';

			$html .= ' </div> <div class="background mb_blck">';
			$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
			$html .= ' </div> </div>';
			return $html;
		}
		else
			return '';
	}

	/**
	 * Checkin Reviews Star Rating
	 * @return string
	 */
	public function getCheckinStarRatingAttribute()
	{
		$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

		$average = @($reviews->sum('checkin') / $reviews->count());

		if($average)
		{
			$html  = '<div class="star-rating"> <div class="foreground">';

			$whole = floor($average);
			$fraction = $average - $whole;

			for($i=0; $i<$whole; $i++)
				$html .= ' <i class="icon icon-beach icon-star"></i>';

			if($fraction >= 0.5)
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';

			$html .= ' </div> <div class="background mb_blck">';
			$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
			$html .= ' </div> </div>';
			return $html;
		}
		else
			return '';
	}

	/**
	 * Cleanliness Reviews Star Rating
	 * @return string
	 */
	public function getCleanlinessStarRatingAttribute()
	{
		$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

		$average = @($reviews->sum('cleanliness') / $reviews->count());

		if($average)
		{
			$html  = '<div class="star-rating"> <div class="foreground">';

			$whole = floor($average);
			$fraction = $average - $whole;

			for($i=0; $i<$whole; $i++)
				$html .= ' <i class="icon icon-beach icon-star"></i>';

			if($fraction >= 0.5)
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';

			$html .= ' </div> <div class="background mb_blck">';
			$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
			$html .= ' </div> </div>';
			return $html;
		}
		else
			return '';
	}

	/**
	 * Value Reviews Star Rating
	 * @return string
	 */
	public function getValueStarRatingAttribute()
	{
		$reviews = Reviews::where('room_id', $this->attributes['id'])->where('user_to', $this->attributes['user_id']);

		$average = @($reviews->sum('value') / $reviews->count());

		if($average)
		{
			$html  = '<div class="star-rating"> <div class="foreground">';

			$whole = floor($average);
			$fraction = $average - $whole;

			for($i=0; $i<$whole; $i++)
				$html .= ' <i class="icon icon-beach icon-star"></i>';

			if($fraction >= 0.5)
				$html .= ' <i class="icon icon-beach icon-star-half"></i>';

			$html .= ' </div> <div class="background mb_blck">';
			$html .= '<i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i> <i class="icon icon-star icon-light-gray"></i>';
			$html .= ' </div> </div>';
			return $html;
		}
		else
			return '';
	}

	/**
	 * Get rooms featured photo_name URL
	 * @deprecated use featured_image attribute instead
	 * @return mixed|string
	 */
	public function getPhotoNameAttribute()
	{
		$result = RoomsPhotos::where('room_id', $this->attributes['id']);

		if($result->count() == 0)
			return url('/')."/images/room_default_no_photos.png";
		else
			return $this->featured_image;
	}

	/**
	 * Get rooms featured photo_name URL
	 * @deprecated use featured_image attribute instead
	 * @return mixed|string
	 */
	public function getSrcAttribute()
	{
		$result = RoomsPhotos::where('room_id', $this->attributes['id'])->where('featured','Yes');

		if($result->count() == 0)
			return url('/')."/images/room_default_no_photos.png";
		else
			return $this->featured_image;
	}

	/**
	 * Get rooms featured photo_name URL
	 * @return mixed|string
	 */
	public function getBannerPhotoNameAttribute()
	{
		$result = RoomsPhotos::where('room_id', $this->attributes['id'])->where('featured','Yes');

		if($result->count() == 0)
			return "room_default_no_photos.png";
		else
			return $result->first()->banner_image_name;
	}

	/**
	 * Get steps_count using sum of rooms_steps_status
	 * @return int|mixed
	 */
	public function getStepsCountAttribute()
	{
		$result = RoomsStepsStatus::find($this->attributes['id']);

		return 8 - (@$result->basics + @$result->description + @$result->location + @$result->photos + @$result->pricing + @$result->calendar + @$result->plans + @$result->terms);
	}

	/**
	 * Get Approved Status
	 * @return mixed|string
	 */
	public function getApprovedStatusAttribute()
	{
		$result = RoomsApprovedStatus::where('room_id', $this->attributes['id'])->first();
		return $result ? $result->approved_status : '0';
	}

	/**
	 * Get property_type_name from property_type table
	 * @return mixed
	 */
	public function getPropertyTypeNameAttribute()
	{
		return PropertyType::find($this->attributes['property_type'])->name;
	}

	/**
	 * Get plan_type_name from property_type table
	 * @return mixed
	 */
	public function getPlanTypeNameAttribute()
	{
		return Subscription::find($this->attributes['plan_type'])->name;
	}


	/**
	 * Get room_type_name from room_type table
	 * @return mixed
	 */
	public function getRoomTypeNameAttribute()
	{
		return RoomType::find($this->attributes['room_type'])->name;
	}

	/**
	 * Get host name from users table
	 * @return mixed
	 */
	public function getHostNameAttribute()
	{
		return User::find($this->attributes['user_id'])->first_name;
	}

	/**
	 * Get host first name from users table
	 * @return mixed
	 */
	public function getHostNameFirstAttribute()
	{
		return User::find($this->attributes['user_id'])->first_name;
	}


	/**
	 * Get host last name from users table
	 * @return mixed
	 */
	public function getHostNameLastAttribute()
	{
		return User::find($this->attributes['user_id'])->last_name;
	}


	/**
	 * Get host id from users table
	 * @return mixed
	 */
	public function getHostIdAttribute()
	{
		return User::find($this->attributes['user_id'])->id;
	}

	// Get bed_type_name from bed_type table

	/**
	 * @return mixed
	 */
	public function getBedTypeNameAttribute()
	{
		if($this->attributes['bed_type'] != NULL)
			return BedType::find($this->attributes['bed_type'])->name;
		else
			return $this->attributes['bed_type'];
	}

	/**
	 * Get full listing slug
	 * @return string
	 */

	public function getLinkAttribute()
	{
		$site_settings_url = @SiteSettings::where('name' , 'site_url')->first()->value;
		$url = \App::runningInConsole() ? $site_settings_url : url('/');
		$this_link = $url.'/'.$this->address_url.'/'.$this->id;
		return $this_link;
	}


	//

	/**
	 * Get Created at Time for Rooms Listed
	 * @return string
	 */
	public function getCreatedTimeAttribute()
	{
		$new_str = new DateTime($this->attributes['updated_at'], new DateTimeZone(Config::get('app.timezone')));
		$new_str->setTimeZone(new DateTimeZone(Auth::user()->timezone));

		return date('Y-m-d H:i:s',strtotime($this->attributes['updated_at'])).' at '.$new_str->format('h:i A');
	}

	/**
	 * delete for rooms relationship data (for all table)
	 * @return bool
	 * @throws \Exception
	 */
	public function Delete_All_Room_Relationship()
	{
		if($this->attributes['id'] !='')
		{
			$RoomsPrice = RoomsPrice::find($this->attributes['id']);
			if($RoomsPrice !=''){
				$RoomsPrice->delete();};

			$RoomsAddress = RoomsAddress::find($this->attributes['id']);
			if($RoomsAddress !=''){ $RoomsAddress->delete();};

			$RoomsPhotos= RoomsPhotos::where('room_id',$this->attributes['id']);
			if($RoomsPhotos !=''){ $RoomsPhotos->delete();};

			$RoomsDescription = RoomsDescription::find($this->attributes['id']);
			if($RoomsDescription !=''){ $RoomsDescription->delete();};

			$RoomsStepsStatus = RoomsStepsStatus::find($this->attributes['id']);
			if($RoomsStepsStatus !=''){ $RoomsStepsStatus->delete();};

			$SavedWishlists = SavedWishlists::where('room_id',$this->attributes['id']);
			if($SavedWishlists !=''){ $SavedWishlists->delete();};

			$RoomsDescriptionLang = RoomsDescriptionLang::where('room_id',$this->attributes['id']);
			if($RoomsDescriptionLang !=''){ $RoomsDescriptionLang->delete();};

			$ImportedIcal = ImportedIcal::where('room_id', $this->attributes['id'])->delete();
			$Calendar = Calendar::where('room_id', $this->attributes['id'])->delete();
			SavedWishlists::where('room_id', $this->attributes['id'])->delete();
			RoomsPriceRules::where('room_id',$this->attributes['id'])->delete();
			RoomsAvailabilityRules::where('room_id', $this->attributes['id'])->delete();

			RoomsPriceRules::where('room_id',$this->attributes['id'])->delete();
			RoomsBath::where('room_id', $this->attributes['id'])->delete();
			SpecialOffer::where('room_id', $this->attributes['id'])->delete();

			Rooms::find($this->attributes['id'])->delete();
			return true;
		}

	}

	/**
	 * @return string
	 */
	public function getShortDescriptionAttribute() {
		$room = $this->bedroom_url . ' ' . $this->property_type_name .' in '. $this->rooms_address->city . ' ' . $this->rooms_address->state;
		return $room;
	}

	/**
	 * @return mixed
	 */
	// public function getNameAttribute()
	// {

	// 	if(Request::segment(1)=='manage-listing' || Request::segment(1)=='admin_url' ){ return $this->attributes['name']; }

	// 	if(Session::get('language'))
	// 	{
	// 		$lang = Session::get('language');
	// 	}
	// 	else
	// 	{
	// 		$default_lang = Language::where('default_language',1)->first()->value;
	// 		$lang = $default_lang;
	// 	}

	// 	if($lang == 'en')
	// 		return $this->attributes['name'];
	// 	else {
	// 		$name = @RoomsDescriptionLang::where('room_id', $this->attributes['id'])->where('lang_code', $lang)->first()->name;
	// 		if($name)
	// 			return $name;
	// 		else
	// 			return $this->attributes['name'];
	// 	}
	// }

	/**
	 * @return mixed
	 */
	// public function getSummaryAttribute()
	// {

	// 	if(Request::segment(1)=='manage-listing' ||  Request::segment(1)=='admin_url'){ return $this->attributes['summary']; }

	// 	$default_lang = Language::where('default_language',1)->first()->value;

	// 	$lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

	// 	if($lang == 'en')
	// 		return $this->attributes['summary'];
	// 	else {
	// 		$name = @RoomsDescriptionLang::where('room_id', $this->attributes['id'])->where('lang_code', $lang)->first()->summary;
	// 		if($name)
	// 			return $name;
	// 		else
	// 			return $this->attributes['summary'];
	// 	}
	// }

	/**
	 * @return false|string
	 */
	public function getRoomCreatedAtAttribute(){
		return date('Y-m-d H:i:s',strtotime($this->attributes['created_at']));
	}

	/**
	 * @return false|string
	 */
	public function getRoomUpdatedAtAttribute(){
		return date('Y-m-d H:i:s',strtotime($this->attributes['created_at']));
	}

	/**
	 * @return mixed
	 */
	public function length_of_stay_rules() {
		return $this->price_rules()->type('length_of_stay');
	}

	/**
	 * @return mixed
	 */
	public function early_bird_rules() {
		return $this->price_rules()->type('early_bird');
	}

	/**
	 * @return mixed
	 */
	public function last_min_rules() {
		return $this->price_rules()->type('last_min');
	}


	/**
	 * Checks if room has a subscription
	 * @return bool
	 */
	public function hasSubscription(){
		if(count($this->subscribe_list)){
			return true;
		}
		return false;
	}


	/**
	 * @return array
	 */
	public static function get_available_subscription_rooms()
	{
		$ids = Rooms::leftJoin( 'subscribe_list', function ( $join ) {
			$join->on( 'subscribe_list.room_id', '=', 'rooms.id' );
		})->where('rooms.user_id', \Auth::user()->id)
		            ->whereNotNull('rooms.braintree_id')
		            ->pluck('rooms.id')->toArray();
		$rooms = array();
		$roomsList = Rooms::where('user_id', \Auth::user()->id)->whereNotIn('id', $ids)->get();
		$room_key = 0;
		if(count($roomsList) >0 ) {
			foreach ($roomsList as $key => $roomItem){
				if($roomItem->steps_count == 0) {
					$rooms[$room_key] = $roomItem;
					$room_key++;
				}
			}
		}
		return $rooms;
		//        return $rooms = Rooms::where('user_id', \Auth::user()->id)->whereNotIn('id', $ids)->get();
	}

	/**
	 * @return array
	 */
	public static function getLenghtOfStayOptions() {
		$nights = Request::segment(1) == 'admin_url' ? 'nights' : trans_choice('messages.rooms.night', 2);
		$weekly = Request::segment(1) == 'admin_url' ? 'Weekly' : trans('messages.lys.weekly');
		$monthly = Request::segment(1) == 'admin_url' ? 'Monthly' : trans('messages.lys.monthly');

		$length_of_stay_options = [
			[
				'nights' => 2,
				'text'   => '2 '.$nights
			],
			[
				'nights' => 3,
				'text'   => '3 '.$nights
			],
			[
				'nights' => 4,
				'text'   => '4 '.$nights
			],
			[
				'nights' => 5,
				'text'   => '5 '.$nights
			],
			[
				'nights' => 6,
				'text'   => '6 '.$nights
			],
			[
				'nights' => 7,
				'text'   => $weekly
			],
			[
				'nights' => 14,
				'text'   => '14 '.$nights
			],
			[
				'nights' => 28,
				'text'   => $monthly
			],
		];
		return $length_of_stay_options;
	}

	/**
	 * @return array|\Illuminate\Support\Collection
	 */
	public static function getAvailabilityRulesMonthsOptions() {
		$month = date('m');
		$year = date('Y');
		$this_time = $start_time = mktime(12, 0, 0, $month, 1, $year);
		$end_time = mktime(12, 0, 0, $month, 1, $year+1);

		$availability_rules_months_options = collect();
		$i = 1;
		while($this_time < $end_time) {
			$loop_time = mktime(12, 0, 0, $month + ($i *3), 0, $year);
			$start_month = date('M Y', $this_time);
			$end_month = date('M Y', $loop_time);
			$availability_rules_months_options[] = [
				'text' => $start_month.' - '.$end_month,
				'start_date' => date('Y-m-d H:i:s', $this_time),
				'end_date' => date('Y-m-d H:i:s', $loop_time),
			];
			$this_time = strtotime('+1 day', $loop_time);
			$i++;
		}
		return $availability_rules_months_options;
	}

	/**
	 * Get Meta Title
	 *
	 * @return string
	 */
	public function getMetaTitleAttribute() {
		if ( $this->seo['meta']['title'] == null ) {
			$name       = Helpers::sanitizeString( $this->name );
			$meta_title = $this->rooms_address->city . ', ' . $this->rooms_address->state . ' ' . 'Vacation Rentals';

			return $meta_title;
		}

		return $this->seo['meta']['title'];
	}

	/**
	 * Get Meta Description
	 *
	 * @return string
	 */
	public function getMetaDescriptionAttribute() {
		if ( $this->seo['meta']['description'] == null ) {
			//Truncate summary
			$summary_excerpt = Helpers::truncate( $this->summary, 300 );
			//now put together the meta description
			$meta_description = 'Reserve your next vacation home for rent in ' . $this->rooms_address->city . ', ' . $this->rooms_address->state . '. ' . $summary_excerpt;

			return $meta_description;
		}

		return $this->seo['meta']['description'];
	}

	/**
	 * Get Meta Image Url
	 *
	 * @return mixed
	 */
	public function getMetaImageAttribute() {
		return $this->featured_image;
	}
	
	/**
	 * Get Meta H1 Tag
	 *
	 * @return mixed
	 */
	public function getMetaH1Attribute() {
		if ( $this->seo['meta']['h1_tag'] == null ) {
			return $this->name;
		}

		return $this->seo['meta']['h1_tag'];
	}

	/**
	 * Return meta keywords
	 *
	 * @return mixed
	 */
	public function getMetaKeywordsAttribute() {
		return $this->seo['meta']['keywords'];
	}

	/**
	 * Temporary full route url
	 *
	 * @deprecated
	 * @return string
	 */
	public function getRouteAttribute() {
		return $this->link;
	}













	public function getFirstnameByUserID(){
		$user = User::find($this->user_id);
		if($user) return $user->first_name;
		else return "";
	}
	
	public function getlastnameByUserID(){
		$user = User::find($this->user_id);
		if($user) return $user->last_name;
		else return "";
	}
	
	public function getRoomAddressByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->address_line_1;
		else return "";
	}
	
	public function getRoomCityByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->city;
		else return "";
	}
	
	public function getRoomStateByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->state;
		else return "";
	}
	
	public function getRoomCountryByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->country;
		else return "";
	}
	public function getMembership(){
		$membership =  Membershiptype::find($this->plan_type);
		if($membership){
			return $membership->Name;
		}
		else{
			return 'Undefined';
		}

	}
}

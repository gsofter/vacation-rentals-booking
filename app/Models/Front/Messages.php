<?php

/**
 * Messages Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Messages
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;
use Auth;
use Config;
use JWTAuth;
use Session;

/**
 * App\Models\Messages
 *
 * @property int $id
 * @property int $room_id
 * @property string $list_type
 * @property int $reservation_id
 * @property int $user_to
 * @property int $user_from
 * @property string|null $message
 * @property int $message_type
 * @property string $read
 * @property string $archive
 * @property string $star
 * @property int|null $special_offer_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $all_count
 * @property-read mixed $archived_count
 * @property-read mixed $created_time
 * @property-read mixed $guest_check
 * @property-read mixed $host_check
 * @property-read mixed $pending_count
 * @property-read mixed $reservation_count
 * @property-read mixed $stared_count
 * @property-read mixed $unread_count
 * @property-read \App\Models\HostExperiences $host_experience
 * @property-read \App\Models\Front\Reservation $reservation
 * @property-read \App\Models\ReservationAlteration $reservation_alteration
 * @property-read \App\Models\Front\Rooms $rooms
 * @property-read \App\Models\Front\RoomsAddress $rooms_address
 * @property-read \App\Models\SpecialOffer|null $special_offer
 * @property-read \App\Models\Front\User $user_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereArchive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereListType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereMessageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereSpecialOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereUserFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Messages whereUserTo($value)
 * @mixin \Eloquent
 */
class Messages extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $appends = ['created_time','pending_count','archived_count','reservation_count','unread_count','stared_count','all_count','host_check','guest_check'];

    // Get All Messages

	/**
	 * @param $user_id
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public static function all_messages($user_id)
    {
        return Messages::where('user_to', $user_id)->groupby('user_from','user_to')->orderBy('id','desc')->get();
    }

    // Get All Message Count

	/**
	 * @return int
	 */
	public  function getAllCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('message_type','!=',5)->get()->count();
    }

    // Get Stared Message Count

	/**
	 * @return int
	 */
	public  function getStaredCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('star', 1)->where('message_type','!=',5)->get()->count();
    }

    // Get Unread Message Count

	/**
	 * @return int
	 */
	public  function getUnreadCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('read', 0)->where('message_type','!=',5)->get()->count();
    }

    // Get Reservation Message Count

	/**
	 * @return int
	 */
	public  function getReservationCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'] )->where('reservation_id','!=', 0)->where('message_type','!=',5)->get()->count();
    }

    // Get Archived Message Count

	/**
	 * @return int
	 */
	public  function getArchivedCountAttribute()
    {
        return Messages::where('user_to', $this->attributes['user_to'])->where('archive', 1)->where('message_type','!=',5)->get()->count();
    }   

    // Get Pending Message Count

	/**
	 * @return int
	 */
	public function getPendingCountAttribute()
    {

       if(Session::get('get_token')!='')
        { 
            $user = JWTAuth::toUser(Session::get('get_token'));
            $user_id=$user->id;

           return Reservation::join('messages', function($join) use($user_id)
            {
                $join->on('messages.reservation_id', '=', 'reservation.id')->where('reservation.status','=', 'Pending')->where('messages.user_to','=', $user_id)->where('message_type','!=',5);
            })->get()->count();
        }
        else
        {
            
           return Reservation::join('messages', function($join)
            {
                $join->on('messages.reservation_id', '=', 'reservation.id')->where('reservation.status','=', 'Pending')->where('messages.user_to','=', Auth::user()->id)->where('message_type','!=',5);
            })->get()->count();
        }  

    }

    // Host Check

	/**
	 * @return int
	 */
	public function getHostCheckAttribute()
    {
         if(Session::get('get_token')!='')
        { 
            $user = JWTAuth::toUser(Session::get('get_token'));

             $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id', $user->id)->get();

        if(count($check) !=0)
            return 1;
        else
            return 0;

          
        }
        else
        {
            $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id', Auth::user()->id )->get();

        if(count($check) !=0)
            return 1;
        else
            return 0;
          
        }  
       
    }

    // Guest Check

	/**
	 * @return int
	 */
	public function getGuestCheckAttribute()
    {
        if(Session::get('get_token')!='')
        { 
            $user = JWTAuth::toUser(Session::get('get_token'));

            $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id',$user->id )->get();

        if(count($check) ==0)
            return 1;
        else
            return 0;

         

          
        }
        else
        {
           $check =  Reservation::where('room_id', $this->attributes['room_id'])->where('host_id', Auth::user()->id )->get();

        if(count($check) ==0)
            return 1;
        else
            return 0;
          
        }  
        
    }

    // Join to User table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user_details()
    {
        return $this->belongsTo('App\Models\Front\User','user_from','id');
    }
    
    // Join to Reservation table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reservation()
    {
        return $this->belongsTo('App\Models\Front\Reservation','reservation_id','id');
    }

    // Join to Reservation Alteration table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reservation_alteration()
    {
        return $this->belongsTo('App\Models\ReservationAlteration','reservation_id','reservation_id');
    }

    // Join to Rooms Address table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms_address()
    {
        return $this->belongsTo('App\Models\Front\RoomsAddress','room_id','room_id');
    }

    // Join to Rooms Address table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
    {
        return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
    }

    // Join to Host Experiences table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function host_experience()
    {
        return $this->belongsTo('App\Models\HostExperiences','room_id','id')->with('city_details');
    }

    // Join to Special Offer table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function special_offer()
    {
        return $this->belongsTo('App\Models\SpecialOffer','special_offer_id','id');
    }

    // Get Created at Time for Message

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getCreatedTimeAttribute()
    {      
          //Check user login from mobile or web.Access from payment,message controller from API
         if(Session::get('get_token')!='')
        {   
            $user = JWTAuth::toUser(Session::get('get_token'));


            $new_str = new DateTime($this->attributes['created_at'], new DateTimeZone(Config::get('app.timezone')));
        $new_str->setTimeZone(new DateTimeZone($user->timezone));

        if(date('d-m-Y') == date('d-m-Y',strtotime($this->attributes['created_at'])))
            return $new_str->format('h:i A');
        else
            return $new_str->format('Y-m-d h:i A');
        }
        else
        {
            
           $new_str = new DateTime($this->attributes['created_at'], new DateTimeZone(Config::get('app.timezone')));
           if(Auth::check())
        $new_str->setTimeZone(new DateTimeZone(Auth::user()->timezone));

        if(date('d-m-Y') == date('d-m-Y',strtotime($this->attributes['created_at'])))
            return $new_str->format('h:i A');
        else
            return $new_str->format('Y-m-d h:i A');
        }     
        
    }
}

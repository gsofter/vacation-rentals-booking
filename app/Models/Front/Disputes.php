<?php
/**
 * Disputes Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Disputes
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Models\Disputes
 *
 * @property int $id
 * @property int $reservation_id
 * @property string $dispute_by
 * @property int $user_id
 * @property int $dispute_user_id
 * @property string $subject
 * @property int $amount
 * @property int|null $final_dispute_amount
 * @property string $currency_code
 * @property string|null $payment_status
 * @property string|null $paymode
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $postal_code
 * @property string $country
 * @property string|null $transaction_id
 * @property string $status
 * @property string $admin_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Front\Currency $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DisputeDocuments[] $dispute_documents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DisputeMessages[] $dispute_messages
 * @property-read \App\Models\Front\User $dispute_user
 * @property-read mixed $created_at_view
 * @property-read mixed $final_dispute_data
 * @property-read mixed $inbox_subject
 * @property-read mixed $maximum_dispute_amount
 * @property-read mixed $status_show
 * @property-read mixed $user_name
 * @property-read mixed $user_or_dispute_user
 * @property-read \App\Models\Front\Reservation $reservation
 * @property-read \App\Models\Front\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes disputeUser()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes receivedUnreadMessages()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes reservationBased($reservation_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes status($status = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes userBased($user_id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes userConversation()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes users()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereAdminStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereDisputeBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereDisputeUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereFinalDisputeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes wherePaymode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Disputes whereUserId($value)
 * @mixin \Eloquent
 */
class Disputes extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'disputes';

    protected $appends = ['user_or_dispute_user', 'created_at_view', 'inbox_subject', 'status_show', 'user_name'];

    //public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reservation()
    {
    	return $this->belongsTo('App\Models\Front\Reservation', 'reservation_id', 'id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
    	return $this->belongsTo('App\Models\Front\User', 'user_id', 'id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function dispute_user()
    {
        return $this->belongsTo('App\Models\Front\User', 'dispute_user_id', 'id');   
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
    {
    	return $this->belongsTo('App\Models\Front\Currency', 'currency_code', 'code');	
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function dispute_messages()
    {
    	return $this->hasMany('App\Models\DisputeMessages', 'dispute_id', 'id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function dispute_documents()
    {
    	return $this->hasMany('App\Models\DisputeDocuments', 'dispute_id', 'id');
    }

	/**
	 * @param      $query
	 * @param null $user_id
	 *
	 * @return mixed
	 */
	public function scopeUserBased($query, $user_id = null)
    {
    	$user_id = $user_id ?: @Auth::user()->id;

    	$query = $query->with(['reservation' => function($query){
                $query->with(['rooms']);
            }])
    		->whereHas('reservation', function($query) use($user_id){
				$query->userRelated($user_id);
			});
		return $query;
    }

	/**
	 * @param $query
	 * @param $reservation_id
	 *
	 * @return mixed
	 */
	public function scopeReservationBased($query, $reservation_id)
    {
        $query = $query->where('reservation_id', $reservation_id);
        return $query;
    }

	/**
	 * @param        $query
	 * @param string $status
	 *
	 * @return mixed
	 */
	public function scopeStatus($query, $status = '')
    {
        if($status != '')
        {
            $query = $query->where('status', $status);
        }

        return $query;
    }

	/**
	 * @param $query
	 */
	public function scopeUsers($query)
    {
        $query = $query->with(['user' => function($query){
            $query->with(['profile_picture']);
        }]);
    }

	/**
	 * @param $query
	 */
	/**
	 * @param $query
	 */
	public function scopeDisputeUser($query)
    {
        $query = $query->with(['dispute_user' => function($query){
            $query->with(['profile_picture']);
        }]);
    }

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeReceivedUnreadMessages($query)
    {
        $query = $query->with(['dispute_messages' => function($query){
            $query->userReceived()->unread();
        }]);
        return $query;
    }

    /*
    * To get the Current User relation to this dispute
    */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getUserOrDisputeUserAttribute()
    {
        $user_or_dispute_user = '';
        $current_user_id = @Auth::user()->id;
        if(request()->segment(1) == 'admin_url')
        {
            $user_or_dispute_user = '';
        }
        else if($this->attributes['user_id'] == $current_user_id)
        {
            $user_or_dispute_user = 'User';
        }
        elseif($this->attributes['dispute_user_id'] == $current_user_id)
        {
            $user_or_dispute_user = 'DisputeUser';
        }
        
        return $user_or_dispute_user;
    }

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getUserNameAttribute(){
        return $this->user->first_name;
    }

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCreatedAtViewAttribute()
    {
        return date(PHP_DATE_FORMAT,strtotime($this->attributes['created_at']));
    }

	/**
	 * @return \Illuminate\Support\Collection
	 */
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getFinalDisputeDataAttribute()
    {
        $amount = $this->attributes['amount'];
        $amount_message = $this->dispute_messages()->withAmount()->lastFirst()->first();

        $final_dispute_data = ['user_to' => 'DisputeUser', 'amount' => $amount];
        if($amount_message)
        {
            $user_to = $this->attributes['user_id'] == $amount_message->user_to ? 'User' : 'DisputeUser';
            $final_dispute_data = ['user_to' => $user_to, 'amount' => $amount_message->amount];
        }

        return collect($final_dispute_data);
    }

	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function getInboxSubjectAttribute()
    {
        $user_or_dispute_user = $this->getUserOrDisputeUserAttribute();
        $currency = $this->currency;
        $amount = html_entity_decode($currency->original_symbol).$this->attributes['amount'];
        $final_dispute_data = $this->final_dispute_data;

        $input_message_data['amount']   = html_entity_decode($currency->original_symbol).$final_dispute_data->get('amount');

        if($user_or_dispute_user == 'User')
        {
            $input_message_data['first_name']   = $this->dispute_user->first_name;
        }
        else
        {
            $input_message_data['first_name']   = $this->user->first_name;
        }

        if($this->attributes['status'] == 'Open')
        {
            if($final_dispute_data->get('user_to') == 'DisputeUser')
            {
                if($user_or_dispute_user == 'User')
                {
                    $input_message_data['message']   = 'you_requested_dispute_amount_from';
                }
                else
                {
                    $input_message_data['message']   = 'user_requested_dispute_amount_from';
                }
            }
            else if($final_dispute_data->get('user_to') == 'User')
            {
                if($user_or_dispute_user == 'User')
                {
                    $input_message_data['message']   = 'user_offered_dispute_amount_to';
                }
                else
                {
                    $input_message_data['message']   = 'you_offered_dispute_amount_to';
                }
            }
        }
        if($this->attributes['status'] == 'Closed')
        {
            if($final_dispute_data->get('user_to') == 'DisputeUser')
            {
                if($user_or_dispute_user == 'User')
                {
                    $input_message_data['message']   = 'user_accepted_dispute_amount_for';
                }
                else
                {
                    if($this->attributes['dispute_by'] == 'Guest')
                    {
                        $input_message_data['message']   = 'you_accepted_dispute_amount_for';
                    }
                    else
                    {
                        $input_message_data['message']   = 'you_paid_dispute_amount_for';   
                    }
                }
            }
            else if($final_dispute_data->get('user_to') == 'User')
            {
                if($user_or_dispute_user == 'User')
                {
                    $input_message_data['message']   = 'you_accepted_dispute_amount_for';
                }
                else
                {
                    $input_message_data['message']   = 'user_accepted_dispute_amount_for';
                }
            }            
        }
        return trans('messages.disputes.'.@$input_message_data['message'], $input_message_data);
    }

	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function getStatusShowAttribute()
    {
        return trans('messages.disputes.'.$this->attributes['status']);
    }

	/**
	 * @return int|mixed
	 */
	/**
	 * @return int|mixed
	 */
	public function getMaximumDisputeAmountAttribute()
    {
        $dispute_by = $this->attributes['dispute_by'];
        $reservation = $this->reservation;

        $maximum_dispute_amount = 0;

        if($dispute_by == 'Guest')
        {
            $maximum_dispute_amount = $reservation->maximum_guest_dispute_amount;
        }
        else
        {
            $maximum_dispute_amount = $reservation->maximum_host_dispute_amount;
        }

        return $maximum_dispute_amount;
    }

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeUserConversation($query)
    {
        $query = $query->with(['dispute_messages'=> function($query){
            $query->userConversation();
        }]);

        return $query;
    }

	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	public function can_dispute_accept_form_show()
    {
        return 
            (
                (
                    (($this->final_dispute_data->get('user_to') == $this->user_or_dispute_user) && $this->attributes['payment_status'] == null) || 
                    ($this->dispute_by == 'Host' && $this->user_or_dispute_user == 'DisputeUser' && $this->attributes['payment_status'] == 'Pending')
                ) && 
                $this->attributes['status'] == 'Open'
            );
    }

	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	public function is_pay()
    {
        return ($this->attributes['dispute_by'] == 'Host' && $this->user_or_dispute_user == 'DisputeUser');
    }
}



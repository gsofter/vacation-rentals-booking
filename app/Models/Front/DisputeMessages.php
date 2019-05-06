<?php
/**
 * DisputeMessages Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    DisputeMessages
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Models\DisputeMessages
 *
 * @property int $id
 * @property int $dispute_id
 * @property string $message_by
 * @property string $message_for
 * @property int $user_from
 * @property int $user_to
 * @property string $message
 * @property int|null $amount
 * @property string $read
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Disputes $dispute
 * @property-read mixed $admin_sub_text
 * @property-read mixed $message_receiver_details
 * @property-read mixed $message_sender_details
 * @property-read mixed $sender_or_receiver
 * @property-read mixed $sub_text
 * @property-read \App\Models\Front\User $receiver_details
 * @property-read \App\Models\Front\User $sender_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages lastFirst()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages unread()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages userConversation($user_id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages userDetails($user_type = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages userReceived($user_id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereDisputeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereMessageBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereMessageFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereUserFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages whereUserTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeMessages withAmount()
 * @mixin \Eloquent
 */
class DisputeMessages extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dispute_messages';

    //public $timestamps = false;

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeUnread($query)
    {
        $query = $query->where('read', 0);
        return $query;
    }

	/**
	 * @param      $query
	 * @param null $user_id
	 *
	 * @return mixed
	 */
	public function scopeUserReceived($query, $user_id = null)
    {
        $user_id = $user_id ?: @Auth::user()->id;

        $query = $query->where('message_for', '!=', 'Admin')->where('user_to', $user_id);
        return $query;
    }

	/**
	 * @param      $query
	 * @param null $user_id
	 *
	 * @return mixed
	 */
	public function scopeUserConversation($query, $user_id = null)
    {
    	$user_id = $user_id ?: @Auth::user()->id;

    	$query = $query->where(function($query) use($user_id){
            $query->where(function($query) use($user_id){
                $query->where('message_for', '!=', 'Admin')->orWhere('user_from', $user_id);
            })->where(function($query) use($user_id){
                $query->where('message_by', '!=', 'Admin')->orWhere('user_to', $user_id);
            });
        });
    	return $query;
    }

	/**
	 * @param        $query
	 * @param string $user_type
	 */
	public function scopeUserDetails($query, $user_type = '')
    {
        if($user_type == 'receiver')
        {
            $query = $query->with(['receiver_details'=> function($query){
                $query->with('profile_picture');
            }]);
        }
        else
        {
            $query = $query->with(['sender_details'=> function($query){
                $query->with('profile_picture');
            }]);
        }
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sender_details()
    {
        return $this->belongsTo('App\Models\Front\User', 'user_from', 'id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function receiver_details()
    {
        return $this->belongsTo('App\Models\Front\User', 'user_to', 'id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function dispute()
    {
        return $this->belongsTo('App\Models\Disputes', 'dispute_id', 'id');
    }

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getMessageReceiverDetailsAttribute()
    {
        $message_receiver_details = [];
        $message_for = $this->attributes['message_for'];
        if($message_for != 'Admin')
        {
            $message_receiver_details = ['name' => $this->receiver_details->first_name, 'profile_picture' => $this->receiver_details->profile_picture->src];
        }
        else
        {
            $message_receiver_details = ['name' => 'Admin', 'profile_picture' => url('images/user_pic-50x50.png')];
        }

        return collect($message_receiver_details);
    }

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getMessageSenderDetailsAttribute()
    {
        $message_sender_details = [];
        $message_by = $this->attributes['message_by'];
        if($message_by != 'Admin')
        {
            $message_sender_details = ['name' => $this->sender_details->first_name, 'profile_picture' => $this->sender_details->profile_picture->src];
        }
        else
        {
            $message_sender_details = ['name' => 'Admin', 'profile_picture' => url('images/user_pic-50x50.png')];
        }

        return collect($message_sender_details);
    }

	/**
	 * @return string
	 */
	public function getSenderOrReceiverAttribute()
    {
        $user_id        = @Auth::user()->id;
        $user_or_admin  = request()->segment(1) == 'admin_url' ? 'Admin' : 'User';
        $user_from      = $this->attributes['user_from'];
        $user_to        = $this->attributes['user_to'];
        $message_by     = $this->attributes['message_by'];
        $message_for    = $this->attributes['message_for'];

        if($user_or_admin == 'Admin')
        {
            $sender_or_receiver = $message_by == 'Admin' ? 'Sender' : 'Receiver';
        }

        if($user_or_admin == 'User')
        {
            if($user_id == $user_from)
            {
                $sender_or_receiver = 'Sender';
            }
            else
            {
                $sender_or_receiver = 'Receiver';
            }

        }

        return $sender_or_receiver;
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
	public function scopeWithAmount($query)
    {
        $query = $query->where('amount', '>', 0);
        return $query;
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
	public function scopeLastFirst($query)
    {
        $query = $query->orderBy('id', 'desc');
        return $query;
    }

	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function getSubTextAttribute()
    {
        if($this->amount <= 0)
        {
            return '';
        }
        $user_or_dispute_user = $this->dispute->getUserOrDisputeUserAttribute();
        $currency = $this->dispute->currency;

        $user_to = $this->dispute->user_id == $this->user_to ? 'User' : 'DisputeUser';
        $final_dispute_data = collect(['user_to' => $user_to, 'amount' => $this->amount]);

        $input_message_data['amount']   = html_entity_decode($currency->original_symbol).$final_dispute_data->get('amount');

        if($user_or_dispute_user == 'User')
        {
            $input_message_data['first_name']   = $this->dispute->dispute_user->first_name;
        }
        else
        {
            $input_message_data['first_name']   = $this->dispute->user->first_name;
        }

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

        return trans('messages.disputes.'.@$input_message_data['message'], $input_message_data);
    }

	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function getAdminSubTextAttribute()
    {
        if($this->amount <= 0)
        {
            return '';
        }
        $user_or_dispute_user = $this->dispute->getUserOrDisputeUserAttribute();
        $currency = $this->dispute->currency;

        $user_to = $this->dispute->user_id == $this->user_to ? 'User' : 'DisputeUser';
        $final_dispute_data = collect(['user_to' => $user_to, 'amount' => $this->amount]);

        $input_message_data['amount']   = html_entity_decode($currency->original_symbol).$final_dispute_data->get('amount');

        if($user_or_dispute_user == 'User')
        {
            $input_message_data['first_name']   = $this->dispute->dispute_user->first_name;
            $input_message_data['firstname']    = $this->dispute->user->first_name;
        }
        else
        {
            $input_message_data['first_name']   = $this->dispute->user->first_name;
            $input_message_data['firstname']    = $this->dispute->dispute_user->first_name;
        }

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

        return trans('messages.disputes.admin_'.@$input_message_data['message'], $input_message_data);
    }
}


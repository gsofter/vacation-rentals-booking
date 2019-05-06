<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use DB;


/**
 * App\Models\Chats
 *
 * @property int $id
 * @property int $user_id
 * @property int $sender_id
 * @property string $message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Front\User $sender
 * @property-read \App\Models\Front\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chats whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chats whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chats whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chats whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chats whereUserId($value)
 * @mixin \Eloquent
 */
class Chats extends Model
{
    /**
     * Fields that are mass assignable
     *
     * @var array
     */

    protected $table = 'chats';
    protected $fillable = ['message','sender_id'];

    /**
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
   public function user()
    {
        return $this->belongsTo('App\Models\Front\User','user_id','id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function sender()
    {
        return $this->belongsTo('App\Models\Front\User','sender_id','id');
    }
}

<?php

namespace App\Models\Front;

use App\Models\Front\Rooms;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RoomsApprovedStatus
 *
 * @property int $id
 * @property int $room_id
 * @property string $approved_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsApprovedStatus whereApprovedStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsApprovedStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsApprovedStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsApprovedStatus whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsApprovedStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Front\Rooms $rooms
 */
class RoomsApprovedStatus extends Model
{
    //
    protected $table = 'rooms_approved_status';
    protected $fillable = ['room_id', 'approved_status'];

    //Relationships

	/**
	 *  Rooms Relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms() {
		return $this->belongsTo( Rooms::class, 'id', 'room_id');
	}
}

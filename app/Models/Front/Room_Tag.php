<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Room_Tag
 *
 * @property int $id
 * @property int $room_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Room_Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Room_Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Room_Tag whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Room_Tag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Room_Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Room_Tag extends Pivot
{
    //
    protected $table = 'room_tag';
    protected $guarded = [];

    
}

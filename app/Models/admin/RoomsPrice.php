<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RoomsPrice extends Authenticatable
{
    protected $table = 'rooms_price';

    public $timestamps = false;

    protected $primaryKey = 'room_id';

    protected $appends = ['steps_count', 'original_night', 'original_cleaning', 'original_additional_guest', 'original_security', 'original_weekend', 'code','original_week','original_month'];

}
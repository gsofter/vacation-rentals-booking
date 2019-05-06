<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RoomType extends Authenticatable
{
    protected $table = 'room_type';

    public $timestamps = false;
}
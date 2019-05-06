<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Models\admin\Rooms;

class Payouts extends Authenticatable
{
    protected $table = 'payouts';

    public $appends = ['currency_symbol', 'date'];

    protected $fillable = ['user_id', 'reservation_id'];

}
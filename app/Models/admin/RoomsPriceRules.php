<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RoomsPriceRules extends Authenticatable
{
    protected $table = 'rooms_price_rules';

    protected $appends = [];

    protected $fillable = ['period', 'discount'];

    public $timestamps = false;
}
<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class Country extends Model
{
    
    protected $table = 'country';
    
    public $timestamps = false;
}

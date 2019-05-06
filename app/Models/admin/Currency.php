<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class Currency extends Model
{
    
    protected $table = 'currency';
    
	public $timestamps = false;
}

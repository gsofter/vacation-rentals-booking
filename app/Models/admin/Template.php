<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class Template extends Model
{    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
	    'type',
	    'action'
    ];

}

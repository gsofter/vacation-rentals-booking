<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class Fees extends Model
{
    
    protected $table = 'fees';

    public $timestamps = false;
}

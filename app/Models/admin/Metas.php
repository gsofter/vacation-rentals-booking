<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class Metas extends Model
{
    
    protected $table = 'metas';

    public $timestamps = false;
}

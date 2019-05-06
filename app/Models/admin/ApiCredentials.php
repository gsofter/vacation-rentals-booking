<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class ApiCredentials extends Model
{
    
    protected $table = 'api_credentials';

    public $timestamps = false;
}

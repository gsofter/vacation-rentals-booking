<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;


class PaymentGateway extends Model
{
    
    protected $table = 'payment_gateway';

    public $timestamps = false;
}

<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PaymentGateway extends Authenticatable
{
    protected $table = 'payment_gateway';

    public $timestamps = false;

}
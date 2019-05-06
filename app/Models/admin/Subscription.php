<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscription extends Authenticatable
{
    protected $table = 'subscription';
    protected $fillable = ['name', 'plan_type', 'amount', 'currency_code', 'images', 'status', 'stripe_plan_code', 'braintree_plan_code','trial_days','days'];

}
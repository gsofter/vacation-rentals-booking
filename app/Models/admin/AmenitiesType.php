<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AmenitiesType extends Authenticatable
{
    protected $table = 'amenities_type';

    public $timestamps = false;
}
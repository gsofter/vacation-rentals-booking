<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PropertyType extends Authenticatable
{
    protected $table = 'property_type';

    public $timestamps = false;
}
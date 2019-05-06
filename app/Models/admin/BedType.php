<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BedType extends Authenticatable
{
    protected $table = 'bed_type';

    public $timestamps = false;
}
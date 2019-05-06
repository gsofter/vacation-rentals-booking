<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmailSettings extends Authenticatable
{
    protected $table = 'email_settings';

    public $timestamps = false;
}
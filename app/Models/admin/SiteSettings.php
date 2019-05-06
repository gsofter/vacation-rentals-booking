<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SiteSettings extends Authenticatable
{
    protected $table = 'site_settings';

    public $timestamps = false;
}
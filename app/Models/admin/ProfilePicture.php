<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Models\admin\Rooms;

class ProfilePicture extends Authenticatable
{
    protected $table = 'profile_picture';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = ['user_id', 'src', 'photo_source'];

    public $appends = ['header_src', 'email_src'];

}
<?php


namespace App\Models\admin;

use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use DB;
use Auth;
use Config;
use Session;
use App\User;
use Request;

class ReferralSettings extends Model {

	protected $table = 'referral_settings';
	
}

<?php

/**
 * Admin Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Admin
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use DB;

/**
 * app\Models\Admin
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string $support_contact
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereSupportContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Admin withoutTrashed()
 * @mixin \Eloquent
 * @property string $last_name
 * @property string $first_name
 * @property string|null $bio
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereLastName($value)
 * @method static bool|null restore()
 */
class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword;

	use EntrustUserTrait { restore as private restoreA; }
	use SoftDeletes { restore as private restoreB; }

	public function restore()
	{
		$this->restoreA();
		$this->restoreB();
	}

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admin';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', 'support_contact', 'first_name','last_name', 'bio'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $dates = ['deleted_at'];

	/**
	 * Update Admin Role
	 *
	 * @param $user_id
	 * @param $role_id
	 *
	 * @return int
	 */
	public static function update_role($user_id, $role_id)
	{
		return DB::table('role_user')->where('user_id', $user_id)->update(['role_id' => $role_id]);
	}

	/**
	 * Scope a query to only include support contact users
	 * @param $query
	 * @return mixed
*/
	public function getSupportContact($query) {
		return $query->where('support_contact', 1);
	}
}

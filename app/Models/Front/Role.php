<?php

/**
 * Role Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Role
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Zizaco\Entrust\EntrustRole;
use DB;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $perms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends EntrustRole
{
	// Get permission_id in lists type
	/**
	 * @param $id
	 *
	 * @return array
	 */
	public static function permission_role($id)
    {
        return DB::table('permission_role')->where('role_id', $id)->pluck('permission_id')->all();
    }

    // Get role_user data by using given id

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
	public static function role_user($id)
    {
        return DB::table('role_user')->where('user_id', $id)->first();
    }
}

<?php

/**
 * Password Resets Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Password Resets
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PasswordResets
 *
 * @property string $email
 * @property string $token
 * @property string $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordResets whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordResets whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordResets whereToken($value)
 * @mixin \Eloquent
 */
class PasswordResets extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    public $timestamps = false;
}

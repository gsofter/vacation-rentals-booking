<?php

/**
 * Page Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Page
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contactus
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $ip_address
 * @property string $contact_type
 * @property string $feedback
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereContactType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contactus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contactus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contactus';
}

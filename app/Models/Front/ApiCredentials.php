<?php

/**
 * Api Credentials Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Api Credentials
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApiCredentials
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $site
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiCredentials whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiCredentials whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiCredentials whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiCredentials whereValue($value)
 * @mixin \Eloquent
 */
class ApiCredentials extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_credentials';

    public $timestamps = false;
}

<?php

/**
 * Payment Gateway Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Payment Gateway
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentGateway
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $site
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentGateway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentGateway whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentGateway whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentGateway whereValue($value)
 * @mixin \Eloquent
 */
class PaymentGateway extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_gateway';

    public $timestamps = false;
}

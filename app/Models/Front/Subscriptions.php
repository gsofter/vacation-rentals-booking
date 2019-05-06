<?php

/**
 * Subscription Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Subscription
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Guzzle\Tests\Service\Mock\Command\Sub\Sub;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use DB;
use DateTime;
use Illuminate\Support\Facades\Route;
use JWTAuth;

/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property string $name
 * @property int $amount
 * @property string $currency_code
 * @property string|null $days
 * @property int $images
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $plan_code
 * @property string|null $payment_type
 * @property-read \App\Models\Front\Currency $currency
 * @property-read mixed $original_amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePlanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $stripe_plan_code
 * @property string|null $braintree_plan_code
 * @property string|null $trial_days
 * @property string $plan_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereBraintreePlanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePlanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereStripePlanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereTrialDays($value)
 */
class Subscriptions extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';
    protected $fillable = ['name', 'user_id', 'stripe_id', 'stripe_plan', 'quantity', 'trial_ends_at', 'ends_at', 'braintree_id', 'braintree_plan'];
   }

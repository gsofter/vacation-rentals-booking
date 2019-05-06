<?php

/**
 * Coupon Code Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Coupon Code
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouponCode
 *
 * @property int $id
 * @property string $coupon_code
 * @property int $amount
 * @property string $currency_code
 * @property string $expired_at
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $description
 * @property string|null $payment_type
 * @property-read mixed $expired_at_dmy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $type
 * @property int|null $max_redemptions
 * @property string $duration
 * @property int|null $duration_in_months
 * @property string|null $stripe_coupon_code
 * @property string|null $braintree_coupon_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereBraintreeCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereDurationInMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereMaxRedemptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereStripeCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CouponCode whereType($value)
 */
class CouponCode extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coupon_code';

    public $timestamps = false;   

    // Convert y-m-d date into d-m-y

	/**
	 * @return false|string
	 */
	public function getExpiredAtDmyAttribute()
    {
        if(@$this->attributes['expired_at'] != '0000-00-00')
            return date(PHP_DATE_FORMAT, strtotime(@$this->attributes['expired_at']));
        else
            return '';
    }
    // Convert y-m-d date into d-m-y

	/**
	 * @return false|string
	 */
	public function getExpiredAtAttribute()
    {
        if(@$this->attributes['expired_at'] != '0000-00-00')
            return date(PHP_DATE_FORMAT, strtotime(@$this->attributes['expired_at']));
        else
            return '';
    }

	/**
	 * @param $payment_type
	 *
	 * @return mixed|string
	 */
	public static function checkAvailableCoupon($payment_type) {
        $couponCode = CouponCode::where('expired_at' ,'>=', date('Y-m-d'))->where('status','Active')->first();
        $coupon = $payment_type.'_coupon_code';
        if(count($couponCode) >0) {
            return $couponCode->$coupon;
        }else{
            return '';
        }
    }
}

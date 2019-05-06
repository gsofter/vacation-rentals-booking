<?php

/**
 * ReservationGuestDetails Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    ReservationGuestDetails
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReservationGuestDetails
 *
 * @property int $id
 * @property int $reservation_id
 * @property string $is_main
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $spot
 * @property string|null $refund_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereRefundStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereSpot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationGuestDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReservationGuestDetails extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservation_guest_details';

}

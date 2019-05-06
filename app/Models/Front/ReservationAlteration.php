<?php

/**
 * Reservation Alteration Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Reservation Alteration
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReservationAlteration
 *
 * @mixin \Eloquent
 */
class ReservationAlteration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservation_alteration';

    public $timestamps = false;
}

<?php

/**
 * Payment Helper
 *
 * @package     Makent
 * @subpackage  Helper
 * @category    Helper
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Http\Helper;
use App\Models\Front\RoomsPrice;
use App\Models\Front\Calendar;
use App\Models\Front\Currency;
use App\Models\Front\Rooms;
use App\Models\Front\SpecialOffer;
use App\Models\Front\Reservation;
use App\Models\Front\Fees;
use App\Models\Front\HostPenalty;
use App\Models\Front\CouponCode;
use App\Models\Front\Payouts;
use App\Models\Front\Referrals;
use App\Models\Front\AppliedTravelCredit;
use DateTime;
use Session;
use Log;

/**
 * Class PaymentHelper
 *
 * @package App\Http\Helper
 */
class PaymentHelper
{
	/**
	 * Common Function for Price Calculation
	 *
	 * @param int    $room_id            Room Id
	 * @param int    $checkin            CheckIn Date
	 * @param int    $checkout           CheckOut Date
	 * @param int    $guest_count        Guest Count
	 * @param array  $guest_options
	 * @param string $special_offer_id   Special Offer Id (Optional)
	 * @param string $change_reservation Dummy string to identify Change reservation or not (Optional)
	 * @param string $reservation_id
	 *
	 * @return json   Calculation Result
	 */

	public function price_calculation($room_id, $checkin, $checkout, $guest_count, $guest_options=[], $special_offer_id = '', $change_reservation='', $reservation_id ='')
	{
        
		$from                               = new DateTime($checkin);
		$to                                 = new DateTime($checkout);
		$date1                              = date('Y-m-d', strtotime($checkin));
		$enddate                            = date('Y-m-d', strtotime($checkout));
		$date2                              = date('Y-m-d', strtotime ( '-1 day' , strtotime ($enddate ) ) );
		$days                               = $this->get_days($date1, $date2 );
		$total_nights                       = $to->diff($from)->format("%a");
		$today                              = new DateTime(date('Y-m-d'));
		$booking_date_diff                  = $from->diff($today)->format("%a")+1;
		$rooms_details                      = Rooms::find($room_id);
		$rooms_price                        = $rooms_details->rooms_price;
		$calendar_result                    = Calendar::where(['room_id' => $room_id])->whereIn('date', $days)->get();


		$result['status']                   = 'Available';
		$result['error']                    = '';
		$result['total_nights']             = $total_nights;
		$result['per_night']                = $rooms_price->night;
		$result['rooms_price']              = $rooms_price->night;
		$result['total_night_price']        = 0;
		$result['base_rooms_price']         = $rooms_price->night;
		$result['night_price']              = 0;
		$result['additional_guest']         = 0;
		$result['security_fee']             = 0;
		$result['cleaning_fee']             = 0;
		$result['coupon_code']              = 0;
		$result['coupon_amount']            = 0;
		$result['currency']                 = 0;
		$result['subtotal']                 = 0;
		$result['total']                    = 0;
		$result['special_offer']            = '';
		$result['payout']                   = 0;
		$result['length_of_stay_type']      = Null;
		$result['length_of_stay_discount']  = 0;
		$result['length_of_stay_discount_price']= 0;
		$result['booked_period_type']       = Null;
		$result['booked_period_discount']   = 0;
		$result['booked_period_discount_price'] = 0;
		$result['taxes_pay']                    = $rooms_price->tax;
		$result['total_taxes_pay']              = 0;
		$result['total_additional_charge']      =0;
		$result['cleaning_fee_type']=$rooms_price->cleaning_fee_type;
		$minimum_stay                       = Null;
		$maximum_stay                       = Null;
		$pre_reserved_days                  = [];
		$result['additional_charge']=$rooms_price->additional_charge;


		$special_price  = 0;
		$special_week   = 0;
		$special_month  = 0;
		$special_night  = 0;
		$special_weekend = 0;
		$special_weekend_count =0;
		$normal_weekend_count = 0;
		$normal_weekend =0;
		$total_special_price = 0;
		$total_special =0;
		$count= 0;
		$total_month_price =0;
		$total_week_price =0;
		$month_price_days =0;
		$week_end_price =0;
		$total_month_price1 =0;
		$total_week_price1 =0;
		$month_price_days1 =0;
		$week_end_price1 =0;
		$total_normal = 0;
		$normal_price =0;
		$normal_week=0;
		$normal_month =0;
		$normal_weekend=0;
		$total_normal_price = 0;
		$sessional_minimum_stay = Null;
		$special_additional_price =0;
		$normal_additional_price = 0;
		$normalprice =0;
		$normalweek=0;
		$normalmonth =0;
		$normalcount =0;
		$check_week_end =0;
		$specialprice =0;
		$specialweek=0;
		$specialmonth =0;
		$specialcount =0;
		$check_special_week_end =0;
		$cnt_for_check_week = 0;
		$interrupted_interval = false;



		if($total_nights < 1) {
			$result['status'] = 'Not available';
			return json_encode($result);
		}
		if($change_reservation) {
			$pre_reservation    = Reservation::find($change_reservation);
			if($pre_reservation) {
				$reservation_checkin  = date('Y-m-d', strtotime($reservation_checkin));
				$reserve_date         = date('Y-m-d', strtotime($reservation_checkout));
				$reservation_checkout = date('Y-m-d', strtotime ( '-1 day' , strtotime ($reserve_date ) ) );
				$pre_reserved_days    = $this->get_days($reservation_checkin, $reservation_checkout );
			}
		}
		if($rooms_details->is_shared == 'Yes') {
			$spots_booked = $calendar_result->max('spots_booked');
			$maximum_spots_can_book = $rooms_details->accommodates - $spots_booked;
			if(($guest_count > $maximum_spots_can_book) && $maximum_spots_can_book > 0) {
				$result['status'] = 'Not available';
				$result['error']  = trans('messages.shared_rooms.maximum_spots_error',['count' => $maximum_spots_can_book]);
			}
		}

		foreach($days as $index => $date){
            
			$reserved_or_unavailable = Calendar::where([
				['date', $date],
				['room_id', $room_id],
				['status', '!=', 'Available']
			])->first();

			if($reserved_or_unavailable !== null){
				$interrupted_interval = true;
			}

			$calendar_data = $calendar_result->where('date', $date)->first();
			$status = $calendar_data ? $calendar_data->isNotAvailable($guest_count) : false;
			if($status && ! in_array( $date, $pre_reserved_days ) ) {
				$result['status'] = 'Not available';
			} else if($calendar_data){

                    
				if($calendar_data->session_weekend != 0) {
                        
					if( date('N',strtotime($date)) == 5 || date('N',strtotime($date)) == 6 ) {
                            
						$special_weekend += $calendar_data->session_weekend;
						++ $special_weekend_count;
                            
						$check_special_week_end = $special_night + $special_weekend_count;

						//do seasonal rate calculations for 30 day date_ranges
						if($check_special_week_end >= 30){
							$specialprice = $special_weekend_count * $calendar_data->session_currency_price;
							$specialmonth = $special_weekend_count * $calendar_data->session_month;
							$specialweek = $special_weekend_count * $calendar_data->session_week;
							$specialcount = $special_weekend_count;
						}
					}else{
						$special_price += $calendar_data->session_currency_price;
						++ $special_night;
						$special_week  += $calendar_data->session_week;
						$special_month += $calendar_data->session_month;
                            
						$check_special_week_end = $special_night + $special_weekend_count;
						if($check_special_week_end >= 30){
							$specialprice = $special_weekend_count * $calendar_data->session_currency_price;
							$specialmonth = $special_weekend_count * $calendar_data->session_month;
							$specialweek = $special_weekend_count * $calendar_data->session_week;
							$specialcount = $special_weekend_count;
						}
					}
					//check if weekly price is set
					if($calendar_data->session_week != 0){
						//increment the number of days
						$cnt_for_check_week++;

						//check if there are any left over nights for 7 night or 30 night date_ranges, if not set weekend price to zero
						if(($cnt_for_check_week % 7 == 0) || ($cnt_for_check_week % 30 == 0)) {
							$special_weekend = 0;
						}
						//check if there are any left over nights for 30 night date_ranges, if not then set weekend price to 0 & reset the day count
						if(($cnt_for_check_week % 30 == 0)) {
						// if(($cnt_for_check_week % 30 == 0) && ($calendar_data->session_month != 0)) {
							$special_weekend = 0;
							$cnt_for_check_week = 0;
						}
					}
				}else{

					$special_price += $calendar_data->session_currency_price;
					++ $special_night;
					$special_week  += $calendar_data->session_week;
					$special_month += $calendar_data->session_month;
                        
				}
				if($calendar_data->additional_guest != 0  && $guest_count > $calendar_data->guests){
					$additional_guest_count     = $guest_count - $calendar_data->guests;
					$special_additional_price   += $additional_guest_count * $calendar_data->additional_guest;
                        
				}
				$minimum_stay = $calendar_data->minimum_stay;
				$sessional_minimum_stay = $calendar_data->minimum_stay;
			}else{
                    
				if($rooms_price->weekend != 0) {
					//check if we're dealing with a 5 or 6 night stay and increment the weekend count
					if( date('N',strtotime($date)) == 5 || date('N',strtotime($date)) == 6 ) {
						$normal_weekend += $rooms_price->weekend;
						++ $normal_weekend_count;
					}else{
						//apply the base nightly rate & base weekend rate
						$normal_price += $rooms_price->night;
						++ $count;
						$normal_week +=  $rooms_price->week;
						$normal_month += $rooms_price->month;
					}
					//check if weekly or monthly price is set
					if($rooms_price->week != 0){
						//increment the number of days
						$cnt_for_check_week++;
						//check if there are any left over nights for 7 night or 30 night date_ranges, if not set weekend price to zero
						if($cnt_for_check_week % 7 == 0) {
							$normal_weekend = 0;
						}
						//check if there are any left over nights for 30 night date_ranges, if not then set weekend price to 0 & reset the day count
						if(($cnt_for_check_week % 30 == 0)  && ($rooms_price->month != 0)) {
							$normal_weekend = 0;
							$cnt_for_check_week = 0;
						}
					}
				}else{
					$normal_price += $rooms_price->night;
					++ $count;
					$normal_week +=  $rooms_price->week;
					$normal_month += $rooms_price->month;
				}
				if(!$sessional_minimum_stay){
					$minimum_stay = $rooms_price->minimum_stay;
				}
				if($rooms_price->additional_guest != 0  && $guest_count > $rooms_price->guests){
					$additional_guest_count     = $guest_count - $rooms_price->guests;
					$normal_additional_price   += $additional_guest_count * $rooms_price->additional_guest;
				}
			}
		}

		if($interrupted_interval === true){
			$result['interrupted'] = true;
			$result['error'] = trans('messages.rooms.interrupted_range');
			return json_encode($result);
		}

		$check_week_end = $count + $normal_weekend_count;
        
		if($check_week_end >= 30){
			$normalprice = $normal_weekend_count * $rooms_price->night;
			$normalmonth = $normal_weekend_count * $rooms_price->month;
			$normalweek = $normal_weekend_count * $rooms_price->week;
			$normalcount = $normal_weekend_count;
			$normal_weekend_count =0;
			$normal_weekend=0;
		}
		$count        += $normalcount;
		$normal_price += $normalprice;
		$normal_week  += $normalweek;
		$normal_month += $normalmonth;
		if($check_special_week_end >= 30){
            
			$special_weekend_count =0;
			$special_weekend=0;
		}
        
		$special_night += $specialcount;
		$special_price += $specialprice;
		$special_week  += $specialweek;
		$special_month += $specialmonth;
        
		if($result['status'] == 'Not available') {
			return json_encode($result);
		}

		if($special_night || $special_weekend_count){
            
			if($special_night){
                
				$month_days             = floor($special_night / 30);
				$month_days_remaining   = number_format($special_night % 30);
				$special_check_week     = $special_night +$special_weekend_count;
                
				if($special_check_week >= 7 && $special_weekend_count !=0){
                    
					$week_days            = floor($month_days_remaining / 5);
					$week_days_remaining  = number_format($month_days_remaining % 5);
                    
				} else{
                    
					$week_days              = floor($month_days_remaining / 7);
					$week_days_remaining    = number_format($month_days_remaining % 7);
                    
				}
				if($month_days) {
                    
					if($special_month !=0) {
                        
						$month_days_round    = floor($special_night  / 30);
						$remaing_month_days  = number_format($special_night  % 30);
						$average_month_price = round(($special_month/$special_night) / 30);
						$round_month_price   = round($month_days_round  * ($special_month/$special_night));
						$remaing_days_price = round(($remaing_month_days  * ($special_price/$special_night))+$round_month_price);
						$total_month_price  = round($remaing_days_price);
					}else {
						$month_price  = round($special_night  * ($special_price/$special_night));
						$total_month_price =  round($month_price);
					}
				}
				if($week_days !=0 && $month_days == 0) {
                    
					if($special_week !=0) {
                        
						if($special_check_week >= 7 && $special_weekend_count !=0){
                            
							$week_days_round    = floor($special_night  / 5);
							$remaing_week_days  = number_format($special_night  % 5);
							$average_week_price = round(($special_week/$special_night) / 5 );
							$round_week_price   = round($week_days_round  * ($special_week/$special_night));
							$remaing_days_price = round(($remaing_week_days  *($special_price/$special_night))+$round_week_price);
							$total_week_price   = round($remaing_days_price);

						}else{
                            
							$week_days_round    = floor($special_night  / 7);
							$remaing_week_days  = number_format($special_night  % 7);
							$average_week_price = round(($special_week/$special_night) / 7 );
							$round_week_price   = round($week_days_round  * ($special_week/$special_night));
							$remaing_days_price = round(($remaing_week_days  *($special_price/$special_night))+$round_week_price);
							$total_week_price   = round($remaing_days_price);
						}
                        
					} else {
                        
						$week_price  = round($special_night  * ($special_price/$special_night));
						$total_week_price =  round($week_price);
					}
				}
				if($week_days_remaining && $week_days ==0 && $month_days == 0) {
                    
					$month_price_days   = round( $special_night * ( $special_price / $special_night) );
                    
				}
				$total_special_price = $total_month_price + $total_week_price + $month_price_days;
                
			}

			if($special_weekend_count ){
                
				$week_end_price = round($special_weekend);
                
			}
			$total_special = $total_special_price + $week_end_price;
            
		}
		if($count || $normal_weekend_count){
			if($count){
				$month_days1            = floor($count / 30);
				$month_days_remaining1  = number_format($count % 30);
				$check_week             = $count +$normal_weekend_count;
				if($check_week >= 7 && $normal_weekend_count !=0){
					$week_days1             = floor($month_days_remaining1 / 5);
					$week_days_remaining1   = number_format($month_days_remaining1 % 5);
				}else{
					$week_days1             = floor($month_days_remaining1 / 7);
					$week_days_remaining1   = number_format($month_days_remaining1 % 7);
				}
				if($month_days1) {
					if($normal_month !=0) {
						$month_days_round1    = floor($count  / 30);
						$remaing_month_days1  = number_format($count  % 30);
						$average_month_price1 = round(($normal_month/$count) / 30);
						$round_month_price1  = round($month_days_round1  * ($normal_month/$count));
						$remaing_days_price1 = round(($remaing_month_days1  * ($normal_price/$count))+$round_month_price1);
						$total_month_price1  = round($remaing_days_price1);
					} else{
						$month_price1  = round($count  * ($normal_price/$count));
						$total_month_price1 =  round($month_price1);
					}
				}
				if($week_days1 !=0 && $month_days1 == 0) {
					if($normal_week !=0) {
						if($check_week >= 7 && $normal_weekend_count !=0){
							$week_days_round1    = floor($count  / 5);
							$remaing_week_days1  = number_format($count  % 5);
							$average_week_price1 = round(($normal_week/$count) / 5 );
							$round_week_price1   = round($week_days_round1  * ($normal_week/$count));
							$remaing_days_price1 = round(($remaing_week_days1  *($normal_price/$count))+$round_week_price1);
							$total_week_price1   = round($remaing_days_price1);
						} else {
							$week_days_round1    = floor($count  / 7);
							$remaing_week_days1  = number_format($count  % 7);
							$average_week_price1 = round(($normal_week/$count) / 7 );
							$round_week_price1   = round($week_days_round1  * ($normal_week/$count));
							$remaing_days_price1 = round(($remaing_week_days1  *($normal_price/$count))+$round_week_price1);
							$total_week_price1   = round($remaing_days_price1);
						}
					} else {
						$week_price1  = round($count * ($normal_price/$count));
						$total_week_price1 =  round($week_price1);
					}
				}
				if($week_days_remaining1 && $week_days1 ==0 && $month_days1 == 0){
					$month_price_days1   = round( $count * ( $normal_price / $count) );
				}
				$total_normal_price = $total_month_price1 + $total_week_price1 + $month_price_days1;
			}
			if($normal_weekend_count){
				$week_end_price1           = round($normal_weekend);
			}
			$total_normal = $total_normal_price + $week_end_price1;
		}

		$result['total_night_price']    = $total_special+$total_normal;
        

		$availability_rules             = $rooms_details->availability_rules()->where(function($query) use($enddate, $date1){
			$query->where('start_date', '<=', $date1)->where('end_date', '>=', $date1);
		})->orderBy('id', 'desc')->get();
		if($availability_rules->count() > 0) {
			$custom_availability_rules = $availability_rules->where('type', 'custom')->first();
			$month_availability_rules = $availability_rules->where('type', 'month')->first();
			if($custom_availability_rules) {
				$minimum_stay = $custom_availability_rules->minimum_stay;
				$maximum_stay = $custom_availability_rules->maximum_stay;
			} else {
				$minimum_stay = $month_availability_rules->minimum_stay;
				$maximum_stay = $month_availability_rules->maximum_stay;
			}
		} else {
			$minimum_stay = $rooms_price->minimum_stay;
			$maximum_stay = $rooms_price->maximum_stay;
		}
		$special_offer = SpecialOffer::find($special_offer_id);
		if(@$special_offer->type != 'special_offer') {
			if($minimum_stay != null && $total_nights < $minimum_stay ) {
				$result['status'] = 'Not available';
				$result['error']  = trans('messages.rooms.minimum_stay_error',['count' => $minimum_stay]);
				return json_encode($result);
			}
			if($maximum_stay != null && $total_nights > $maximum_stay ) {
				$result['status'] = 'Not available';
				$result['error']  = trans('messages.rooms.maximum_stay_error',['count' => $maximum_stay]);
				return json_encode($result);
			}
		}
		$result['base_rooms_price']  = round($result['total_night_price'] / $total_nights);
		$result['night_price']  = $result['total_night_price'];
		$early_bird_rules     = $rooms_details->early_bird_rules->sortByDesc('period')->toArray();
		foreach($early_bird_rules as $rule) {
			if($booking_date_diff >= @$rule['period'] && @$rule['discount'] > 0) {
				$result['booked_period_type']           = @$rule['type'];
				$result['booked_period_discount']       = @$rule['discount'];
				$result['booked_period_discount_price'] = round ( ( @$rule['discount'] / 100 ) * $result['night_price'] );
				$result['night_price']                  -= $result['booked_period_discount_price'];
				break;
			}
		}
		if($result['booked_period_type'] == Null) {
			$last_min_rules     = $rooms_details->last_min_rules->sortBy('period')->toArray();
			foreach($last_min_rules as $rule) {
				if(@$rule['period'] >= $booking_date_diff && @$rule['discount'] > 0) {
					$result['booked_period_type']           = @$rule['type'];
					$result['booked_period_discount']       = @$rule['discount'];
					$result['booked_period_discount_price'] = round ( ( @$rule['discount'] / 100 ) * $result['night_price'] );
					$result['night_price']                  -= $result['booked_period_discount_price'];
					break;
				}
			}
		}
		$length_of_stay_rules   = $rooms_details->length_of_stay_rules;
		$length_of_stay_rules = $length_of_stay_rules->sortByDesc('period')->toArray();
		foreach($length_of_stay_rules as $rule) {
			if($total_nights >= @$rule['period'] && @$rule['discount'] > 0) {
				$result['length_of_stay_type']           = @$rule['period'] == 7 ? 'weekly' : ( @$rule['period'] == 28 ? 'monthly' : 'custom');
				$result['length_of_stay_discount']       = @$rule['discount'];
				$result['length_of_stay_discount_price'] = round ( ( @$rule['discount'] / 100 ) * $result['night_price'] );
				$result['night_price']                   -= $result['length_of_stay_discount_price'];
				break;
			}
		}
		$result['per_night']          = round($result['night_price'] / $total_nights);		
		if($guest_count > $rooms_price->guests) {
		  $additional_guest_count     = $guest_count - $rooms_price->guests;
		  // $result['additional_guest'] = $additional_guest_count * $rooms_price->additional_guest * $total_nights; // Additional guest fee is calculated per night
		} else {
			$additional_guest_count = 0;
		}
		$result['additional_guest'] = $normal_additional_price+$special_additional_price;
		if($rooms_price->security) {
			$result['security_fee']     = $rooms_price->security;
		}
		if($rooms_price->cleaning) {
			$result['cleaning_fee']     = $rooms_price->cleaning;
		}
		$result['subtotal']           = $result['night_price'] + $result['additional_guest'] + $result['security_fee'] + $result['cleaning_fee'];
		$result['rooms_price']        = round($result['subtotal'] / $total_nights);		
		$result['currency']           = $rooms_price->currency_code;		
		$reservation                  = Reservation::find($reservation_id);
		if($reservation) {
			$result['additional_guest'] = $reservation->additional_guest;
			$result['security_fee']     = $reservation->security;
			$result['cleaning_fee']     = $reservation->cleaning;
			$result['coupon_amount']    = $reservation->coupon_amount;
			$result['total_night_price']= $reservation->base_per_night * $reservation->nights;
			$result['base_rooms_price'] = $reservation->base_per_night;
			$result['night_price']      = $reservation->per_night * $reservation->nights;
			$result['per_night']        = $reservation->per_night;
			$result['rooms_price']      = round($reservation->subtotal / $reservation->nights);
			$result['length_of_stay_type']           = $reservation->length_of_stay_type;
			$result['length_of_stay_discount']       = $reservation->length_of_stay_discount;
			$result['length_of_stay_discount_price'] = $reservation->length_of_stay_discount_price;
			$result['booked_period_type']            = $reservation->booked_period_type;
			$result['booked_period_discount']        = $reservation->booked_period_discount;
			$result['booked_period_discount_price']  = $reservation->booked_period_discount_price;
			$result['total_nights']     = $reservation->nights;
			$result['subtotal']         = $reservation->subtotal;

			$result['special_offer']    = $reservation->special_offer_id;
			$result['payout']           = $reservation->payout;
			$result['currency']         = $reservation->currency->code;
		}

		$special_offer                = SpecialOffer::find($special_offer_id);
		if($special_offer && @$special_offer->type == 'special_offer') {
			$result['special_offer']    = "yes";
			$result['total_night_price']= $special_offer->price;
			$result['per_night']        = round( $special_offer->price/$total_nights );
			$result['rooms_price']      = round( $special_offer->price/$total_nights );
			$result['base_rooms_price'] = round( $special_offer->price/$total_nights );
			$result['subtotal']         = $special_offer->price;

			$result['length_of_stay_type']           = null;
			$result['length_of_stay_discount']       = 0;
			$result['length_of_stay_discount_price'] = 0;
			$result['booked_period_type']            = null;
			$result['booked_period_discount']        = 0;
			$result['booked_period_discount_price']  = 0;
		}
		$coupon_amount_total          = $result['subtotal'];
		if(Session::get('coupon_code')) {
			$coupon_code    = Session::get('coupon_code');
			if($coupon_code == 'Travel_Credit') {
				$coupon_amount            = Session::get('coupon_amount');
				$result['coupon_amount']  = ($coupon_amount_total >= $coupon_amount) ? $coupon_amount : $coupon_amount_total;
			}else {
				$coupon_details           = CouponCode::where('coupon_code', $coupon_code)->first();
				if($coupon_details) {
					$code                   = Session::get('currency');
					$result['coupon_amount']= $this->currency_convert($coupon_details->currency_code,$code,$coupon_details->amount);
				}
			}
			$result['coupon_code']      = $coupon_code;
		}

		$additional_charges = array();
		$result['additional'] = array();
		if (! empty($result['additional_charge']) && $result['additional_charge'] != Null) {			
			foreach (json_decode($result['additional_charge']) as $key => $charge) {				
				$add_charge['label'] = $charge->label;				

				if($charge->price_type == 0) {	// percentage					
					if($charge->calc_type == 0) {	// single fee
						$add_charge['price'] = $charge->price * 0.01 * $result['subtotal'];
					} else if ($charge->calc_type == 1) {	// per night
						$add_charge['price'] = $charge->price * 0.01 * $result['total_night_price'];						
					} else if ($charge->calc_type == 2) {	// per guest					
						$add_charge['price'] = $charge->price * 0.01 * $result['subtotal'] * $guest_count;
					}

				} else if($charge->price_type == 1) {	// flat rate					
					if($charge->calc_type == 0) {	// single fee
					
						$add_charge['price'] = $charge->price;
					} else if ($charge->calc_type == 1) {	// per night						
						$add_charge['price'] = $charge->price * $total_nights;
					} else if ($charge->calc_type == 2) {	// per guest							
						$add_charge['price'] = $charge->price * $guest_count;				
					}
				}

				$add_charge_amount = $add_charge['price'];
				$add_charge['price'] = number_format($add_charge['price'], 2);

				if($charge->guest_opt == 0) {	// yes
					// $add_charge['guest_opt'] = true;					
					if(isset($guest_options[$charge->label]) && $guest_options[$charge->label] == 1) {
						$result['additional'][]            = $add_charge;
						$result['total_additional_charge'] += $add_charge_amount;	
					} else {
						$add_charge['price']    = '---';
						$result['additional'][] = $add_charge;
					}
				} else if($charge->guest_opt == 1) {	//  no
					$result['additional'][]            = $add_charge;
					$result['total_additional_charge'] += $add_charge_amount;
					// $add_charge['guest_opt'] = false;
				}

				
			}

		}

		

		$result['total_taxes_pay']      = (($result['subtotal'] + $result['total_additional_charge'])*$result['taxes_pay'])/100;
		$result['payment_total']      = ( $result['subtotal'] + $result['total_additional_charge'] + $result['total_taxes_pay'] );
		$result['payout']             = $result['total'];

		$result['total_price']        =  $result['subtotal'] + $result['total_additional_charge'] + $result['total_taxes_pay'];		
		$result['total_taxes_price']  = $result['total_taxes_pay'];
		
		$result['total_taxes_pay']    = number_format($result['total_taxes_pay'], 2);		// string for displaying in view
		$result['total']              =  number_format($result['total_price'], 2);			// string for displaying in view
		return json_encode($result);
	}


	/**
	 * Calculate reservation price
	 * @param        $room_id
	 * @param        $checkin
	 * @param        $checkout
	 * @param        $guest_count
	 * @param string $special_offer_id
	 * @param string $change_reservation
	 * @param string $reservation_id
	 * @deprecated
	 * @return false|string
	 */
	public function price_calculation_old($room_id, $checkin, $checkout, $guest_count, $special_offer_id = '', $change_reservation='', $reservation_id ='')
	{
		$from                               = new DateTime($checkin);
		$to                                 = new DateTime($checkout);
		$date1                              = date('Y-m-d', strtotime($checkin));
		$enddate                            = date('Y-m-d', strtotime($checkout));
		$date2                              = date('Y-m-d', strtotime ( '-1 day' , strtotime ($enddate ) ) );
		$days                               = $this->get_days($date1, $date2 );
		$total_nights                       = $to->diff($from)->format("%a");
		$today                              = new DateTime(date('Y-m-d'));
		$booking_date_diff                  = $from->diff($today)->format("%a")+1;

		$rooms_details                      = Rooms::find($room_id);
		$rooms_price                        = $rooms_details->rooms_price;
		$calendar_result                    = Calendar::where(['room_id' => $room_id])->whereIn('date', $days)->get();

		$service_fee_percentage             = Fees::find(1)->value;
		$host_fee_percentage                = Fees::find(2)->value;

		$result['status']                   = 'Available';
		$result['error']                    = '';
		$result['total_nights']             = $total_nights;
		$result['per_night']                = $rooms_price->night;
		$result['rooms_price']              = $rooms_price->night;
		$result['total_night_price']        = 0;
		$result['base_rooms_price']         = $rooms_price->night;
		$result['night_price']              = 0;
		$result['additional_guest']         = 0;
		$result['security_fee']             = 0;
		$result['cleaning_fee']             = 0;
		$result['service_fee']              = 0;
		$result['host_fee']                 = 0;
		$result['coupon_code']              = 0;
		$result['coupon_amount']            = 0;
		$result['currency']                 = 0;
		$result['subtotal']                 = 0;
		$result['total']                    = 0;
		$result['special_offer']            = '';
		$result['payout']                   = 0;

		$result['length_of_stay_type']      = Null;
		$result['length_of_stay_discount']  = 0;
		$result['length_of_stay_discount_price']= 0;
		$result['booked_period_type']       = Null;
		$result['booked_period_discount']   = 0;
		$result['booked_period_discount_price'] = 0;


		$minimum_stay                       = Null;
		$maximum_stay                       = Null;
		$pre_reserved_days                  = [];

		if($total_nights < 1) {
			$result['status'] = 'Not available';
			return json_encode($result);
		}
		if($change_reservation) {
			$pre_reservation          = Reservation::find($change_reservation);
			if($pre_reservation)
			{
				$reservation_checkin  = date('Y-m-d', strtotime($reservation_checkin));
				$reserve_date         = date('Y-m-d', strtotime($reservation_checkout));
				$reservation_checkout = date('Y-m-d', strtotime ( '-1 day' , strtotime ($reserve_date ) ) );
				$pre_reserved_days    = $this->get_days($reservation_checkin, $reservation_checkout );
			}
		}
		if($rooms_details->is_shared == 'Yes')
		{
			$spots_booked = $calendar_result->max('spots_booked');
			$maximum_spots_can_book = $rooms_details->accommodates - $spots_booked;

			if(($guest_count > $maximum_spots_can_book) && $maximum_spots_can_book > 0)
			{
				$result['status'] = 'Not available';
				$result['error']  = trans('messages.shared_rooms.maximum_spots_error',['count' => $maximum_spots_can_book]);
			}
		}

		foreach($days as $date) {
			$calendar_data = $calendar_result->where('date', $date)->first();
			$status = $calendar_data ? $calendar_data->isNotAvailable($guest_count) : false;

			if($status && !in_array($date, $pre_reserved_days)) {
				$result['status'] = 'Not available';
			}else {
				$price = $rooms_price->night;
				if( $rooms_price->weekend != 0 && ( date( 'N', strtotime( $date ) ) == 5 || date( 'N', strtotime( $date ) ) == 6 ) ) {
					$price = $rooms_price->weekend;
				}
				$price =  $calendar_data ? $calendar_data->session_currency_price : $price;
				$result['total_night_price'] += $price;
			}
		}
		if($result['status'] == 'Not available') {
			return json_encode($result);
		}

		$availability_rules       = $rooms_details->availability_rules()->where(function($query) use($enddate, $date1){
			$query->where('start_date', '<=', $date1)->where('end_date', '>=', $date1);
		})->orderBy('id', 'desc')->get();

		if($availability_rules->count() > 0) {
			$custom_availability_rules = $availability_rules->where('type', 'custom')->first();
			$month_availability_rules = $availability_rules->where('type', 'month')->first();
			if($custom_availability_rules) {
				$minimum_stay = $custom_availability_rules->minimum_stay;
				$maximum_stay = $custom_availability_rules->maximum_stay;
			}
			else {
				$minimum_stay = $month_availability_rules->minimum_stay;
				$maximum_stay = $month_availability_rules->maximum_stay;
			}
		}
		else {
			$minimum_stay = $rooms_price->minimum_stay;
			$maximum_stay = $rooms_price->maximum_stay;
		}

		$special_offer                = SpecialOffer::find($special_offer_id);
		if(@$special_offer->type != 'special_offer') {
			if($minimum_stay != null && $total_nights < $minimum_stay ) {
				$result['status'] = 'Not available';
				$result['error']  = trans('messages.rooms.minimum_stay_error',['count' => $minimum_stay]);
				return json_encode($result);
			}
			if($maximum_stay != null && $total_nights > $maximum_stay ) {
				$result['status'] = 'Not available';
				$result['error']  = trans('messages.rooms.maximum_stay_error',['count' => $maximum_stay]);
				return json_encode($result);
			}
		}

		$result['base_rooms_price']  = round($result['total_night_price'] / $total_nights);
		$result['night_price']  = $result['total_night_price'];

		$early_bird_rules     = $rooms_details->early_bird_rules->sortByDesc('period')->toArray();
		foreach($early_bird_rules as $rule) {
			if($booking_date_diff >= @$rule['period'] && @$rule['discount'] > 0) {
				$result['booked_period_type']           = @$rule['type'];
				$result['booked_period_discount']       = @$rule['discount'];
				$result['booked_period_discount_price'] = round ( ( @$rule['discount'] / 100 ) * $result['night_price'] );
				$result['night_price']                  -= $result['booked_period_discount_price'];
				break;
			}
		}

		if($result['booked_period_type'] == Null) {
			$last_min_rules     = $rooms_details->last_min_rules->sortBy('period')->toArray();
			foreach($last_min_rules as $rule) {
				if(@$rule['period'] >= $booking_date_diff && @$rule['discount'] > 0) {
					$result['booked_period_type']           = @$rule['type'];
					$result['booked_period_discount']       = @$rule['discount'];
					$result['booked_period_discount_price'] = round ( ( @$rule['discount'] / 100 ) * $result['night_price'] );
					$result['night_price']                  -= $result['booked_period_discount_price'];
					break;
				}
			}
		}

		$length_of_stay_rules   = $rooms_details->length_of_stay_rules;
		$length_of_stay_rules = $length_of_stay_rules->sortByDesc('period')->toArray();

		foreach($length_of_stay_rules as $rule) {
			if($total_nights >= @$rule['period'] && @$rule['discount'] > 0) {
				$result['length_of_stay_type']           = @$rule['period'] == 7 ? 'weekly' : ( @$rule['period'] == 28 ? 'monthly' : 'custom');
				$result['length_of_stay_discount']       = @$rule['discount'];
				$result['length_of_stay_discount_price'] = round ( ( @$rule['discount'] / 100 ) * $result['night_price'] );
				$result['night_price']                   -= $result['length_of_stay_discount_price'];
				break;
			}
		}
		$result['per_night']          = round($result['night_price'] / $total_nights);

		if($guest_count > $rooms_price->guests) {
			$additional_guest_count     = $guest_count - $rooms_price->guests;
			$result['additional_guest'] = $additional_guest_count * $rooms_price->additional_guest * $total_nights; // Additional guest fee is calculated per night
		}
		if($rooms_price->security) {
			$result['security_fee']     = $rooms_price->security;
		}
		if($rooms_price->cleaning) {
			$result['cleaning_fee']     = $rooms_price->cleaning;
		}

		$result['service_fee']        = round( ($service_fee_percentage / 100) * ($result['night_price'] + $result['additional_guest'] + $result['cleaning_fee']) );
		$result['host_fee']           = round( ($host_fee_percentage / 100) * ($result['night_price'] + $result['additional_guest'] + $result['cleaning_fee']) );
		$result['subtotal']           = $result['night_price'] + $result['additional_guest'] + $result['security_fee'] + $result['cleaning_fee'];
		$result['rooms_price']        = round($result['subtotal'] / $total_nights);
		$result['currency']           = $rooms_price->code;

		$reservation                  = Reservation::find($reservation_id);
		if($reservation)  {
			$result['additional_guest'] = $reservation->additional_guest;
			$result['security_fee']     = $reservation->security;
			$result['cleaning_fee']     = $reservation->cleaning;
			$result['coupon_amount']    = $reservation->coupon_amount;
			$result['total_night_price']= $reservation->base_per_night * $reservation->nights;
			$result['base_rooms_price'] = $reservation->base_per_night;
			$result['night_price']      = $reservation->per_night * $reservation->nights;
			$result['per_night']        = $reservation->per_night;
			$result['rooms_price']      = round($reservation->subtotal / $reservation->nights);
			$result['length_of_stay_type']           = $reservation->length_of_stay_type;
			$result['length_of_stay_discount']       = $reservation->length_of_stay_discount;
			$result['length_of_stay_discount_price'] = $reservation->length_of_stay_discount_price;
			$result['booked_period_type']            = $reservation->booked_period_type;
			$result['booked_period_discount']        = $reservation->booked_period_discount;
			$result['booked_period_discount_price']  = $reservation->booked_period_discount_price;
			$result['total_nights']     = $reservation->nights;
			$result['service_fee']      = $reservation->service;
			$result['host_fee']         = $reservation->host_fee;
			$result['subtotal']         = $reservation->subtotal;
			$result['special_offer']    = $reservation->special_offer_id;
			$result['payout']           = $reservation->payout;
			$result['currency']         = $reservation->currency->code;
		}

		$special_offer                = SpecialOffer::find($special_offer_id);
		if($special_offer && @$special_offer->type == 'special_offer') {
			$result['special_offer']    = "yes";
			$result['total_night_price']= $special_offer->price;
			$result['per_night']        = round( $special_offer->price/$total_nights );
			$result['rooms_price']      = round( $special_offer->price/$total_nights );
			$result['base_rooms_price'] = round( $special_offer->price/$total_nights );
			$result['service_fee']      = round(($service_fee_percentage / 100) * $special_offer->price);
			$result['host_fee']         = round(($host_fee_percentage / 100) * $special_offer->price);
			$result['subtotal']         = $special_offer->price;

			$result['length_of_stay_type']           = null;
			$result['length_of_stay_discount']       = 0;
			$result['length_of_stay_discount_price'] = 0;
			$result['booked_period_type']            = null;
			$result['booked_period_discount']        = 0;
			$result['booked_period_discount_price']  = 0;
		}

		$coupon_amount_total          = $result['subtotal'] + $result['service_fee'];
		if(Session::get('coupon_code')) {
			$coupon_code                = Session::get('coupon_code');
			if($coupon_code == 'Travel_Credit')
			{
				$coupon_amount            = Session::get('coupon_amount');
				$result['coupon_amount']  = ($coupon_amount_total >= $coupon_amount) ? $coupon_amount : $coupon_amount_total;
			}
			else
			{
				$coupon_details           = CouponCode::where('coupon_code', $coupon_code)->first();
				if($coupon_details) {
					$code                   = Session::get('currency');
					$result['coupon_amount']= $this->currency_convert($coupon_details->currency_code,$code,$coupon_details->amount);
				}
			}
			$result['coupon_code']      = $coupon_code;
		}

		$result['total']              = ( $result['subtotal'] + $result['service_fee'] +$result['total_taxes_pay'] ) - $result['coupon_amount'];
		$result['payment_total']      = ( $result['subtotal'] + $result['service_fee'] )  - $result['security_fee'] - $result['coupon_amount'];
		$result['payout']             = $result['total'] - $result['service_fee'] - $result['host_fee'];

		return json_encode($result);
	}

	/**
	 * Get days between two dates
	 *
	 * @param date $sStartDate  Start Date
	 * @param date $sEndDate    End Date
	 * @return array $days      Between two dates
	 */
	public function get_days($sStartDate, $sEndDate)
	{
		$aDays[]      = $sStartDate;
		$sCurrentDate = $sStartDate;

		while($sCurrentDate < $sEndDate)
		{
			$sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
			$aDays[]      = $sCurrentDate;
		}

		return $aDays;
	}

	/**
	 * Currency Convert
	 *
	 * @param string $from  Currency Code From
	 * @param string $to    Currency Code To
	 * @param int    $price Price Amount
	 *
	 * @return int Converted amount
	 */
	public function currency_convert($from = '', $to = '', $price)
	{
		if($from == '')
		{
			if(Session::get('currency')) {
				$from = Session::get( 'currency' );
			}
			else {
				$from = Currency::where( 'default_currency', 1 )->first()->code;
			}
		}

		if($to == '')
		{
			if(Session::get('currency')) {
				$to = Session::get( 'currency' );
			}
			else {
				$to = Currency::where( 'default_currency', 1 )->first()->code;
			}
		}

		$rate = Currency::whereCode($from)->first()->rate;

		$usd_amount = floor((float)$price) / $rate;

		$session_rate = Currency::whereCode($to)->first()->rate;

		return round($usd_amount * $session_rate);
	}

	/**
	 * Currency Rate
	 *
	 * @param int $from   Currency Code From
	 * @param int $to     Currency Code To
	 * @return int Converted Currency Rate
	 */
	public function currency_rate($from, $to)
	{
		$from_rate = Currency::whereCode($from)->first()->rate;
		$to_rate = Currency::whereCode($to)->first()->rate;

		return round($from_rate / $to_rate);
	}

	/**
	 * Date Convert
	 *
	 * @param date $date   Given Date
	 * @return date Converted new date format
	 */
	public function date_convert($date)
	{
		return date('Y-m-d', $this->custom1_strtotime($date));
	}

	/**
	 * Custom date conversion
	 * @param $date
	 *
	 * @return false|int
	 */
	public function custom1_strtotime($date)
	{
		if(PHP_DATE_FORMAT=="d/m/Y" || PHP_DATE_FORMAT=="m-d-Y")
		{
			$seperator=(PHP_DATE_FORMAT=="d/m/Y")? "/" : "-";
			$explode_date=explode($seperator,$date);
			if(count($explode_date)=="1")
			{
				return strtotime($date);
			}
			else
			{
				$original_date=$explode_date[1].$seperator.$explode_date[0].$seperator.$explode_date[2];
				return strtotime($original_date);
			}
		}
		else
		{
			return strtotime($date);
		}
	}

	/**
	 * Penalty Amount Check
	 *
	 * @param $penalty
	 * @param $reservation_amount
	 * @param $reservation_currency_code
	 * @deprecated
	 * @return check if any penalty for this host then renturn remaining amount
	 */

	public function check_host_penalty($penalty, $reservation_amount,$reservation_currency_code)
	{
		$penalty_id = '';
		$penalty_amount = '';

		if($penalty->count() > 0 )
		{
			$host_amount = $reservation_amount;
			foreach ($penalty as $pen) {
				$host_amount = $this->currency_convert($reservation_currency_code,$pen->currency_code,$host_amount); // Convert the host amount to peanlty currency to compare

				$remaining_amount = $pen->remain_amount;
				if($host_amount >= $remaining_amount)
				{
					$host_amount -= $remaining_amount;

					$pen->remain_amount    = 0;
					$pen->status           = "Completed";
					$pen->save();

					$penalty_id .= $pen->id.',';
					$penalty_amount .= $remaining_amount.',';
				}
				else
				{
					$amount_reamining = $remaining_amount - $host_amount;

					$pen->remain_amount  = $amount_reamining;
					$pen->save();

					$penalty_id .= $pen->id.',';
					$penalty_amount .= $amount_reamining.',';

					$host_amount = 0;
				}
				$host_amount = $this->currency_convert($pen->currency_code,$reservation_currency_code,$host_amount); // Revert the host amount to reservation currency code

			}
			$penalty_id     = rtrim($penalty_id, ',');
			$penalty_amount = rtrim($penalty_amount, ',');
		}
		else
		{
			$host_amount = $reservation_amount;
			$penalty_id     = 0;
			$penalty_amount = 0;
		}

		$result['host_amount']     = $host_amount;
		$result['penalty_id']      = $penalty_id;
		$result['penalty_amount']  = $penalty_amount;

		return $result;
	}

	/**
	 * @param $reservation_id
	 * @deprecated
	 * @throws \Exception
	 */
	public function revert_travel_credit($reservation_id) {

		$applied_referrals = AppliedTravelCredit::whereReservationId($reservation_id)->get();

		foreach($applied_referrals as $row) {
			$referral = Referrals::find($row->referral_id);

			if($row->type == 'main') {
				$referral->credited_amount += $this->currency_convert( $row->currency_code, $referral->currency_code, $row->original_amount );
			}
			else {
				$referral->friend_credited_amount += $this->currency_convert( $row->currency_code, $referral->currency_code, $row->original_amount );
			}

			$referral->save();

			$applied_referrals = AppliedTravelCredit::find($row->id)->delete();
		}

	}


	/**
	 * To process the payouts and refunds based on reservations
	 *
	 * @param App\Models\Front\Reservation $reservation
	 * @param Int                    $guest_refundable_amount
	 * @param Int                    $host_payout_amount
	 * @param int                    $host_penalty_amount
	 * @deprecated
	 * @throws \Exception
	 */
	public function payout_refund_processing($reservation, $guest_refundable_amount = 0, $host_payout_amount = 0, $host_penalty_amount = 0)
	{
		// Create new / Find Payout row for Guest & Host
		$guest_check_data = array(
			'user_id' => $reservation->user_id,
			'reservation_id' => $reservation->id,
		);
		$guest_refund = Payouts::firstOrNew($guest_check_data);

		$host_check_data = array(
			'user_id' => $reservation->host_id,
			'reservation_id' => $reservation->id,
		);
		$host_payout = Payouts::firstOrNew($host_check_data);

		// Revert already applied penalty for this reservation
		if(@$host_payout->penalty_id != 0 && @$host_payout->penalty_id != '')
		{
			$penalty_id = explode(",",$host_payout->penalty_id);
			$penalty_amt = explode(",",$host_payout->penalty_amount);
			$i =0;
			foreach ($penalty_id as $row)
			{
				$old_amt = HostPenalty::where('id',$row)->get();
				$upated_amt = $old_amt[0]->remain_amount + $penalty_amt[$i];
				HostPenalty::where('id',$row)->update(['remain_amount' => $upated_amt,'status' => 'Pending' ]);
				$i++;
			}
		}

		// Process and Save guest refund amount
		if($guest_refundable_amount > 0)
		{
			if(!@$guest_refund->id)
			{
				$guest_refund->reservation_id = $reservation->id;
				$guest_refund->room_id        = $reservation->room_id;
				$guest_refund->user_id        = $reservation->user_id;
				$guest_refund->user_type      = 'guest';
				$guest_refund->currency_code  = $reservation->currency_code;
				$guest_refund->status         = 'Future';
				$guest_refund->save();
			}
			$guest_refund->currency_code  = $reservation->currency_code;
			$guest_refund->amount         = $guest_refundable_amount;
			$guest_refund->currency_code  = $reservation->currency_code;
			$guest_refund->save();
		}

		// Save the host penalty amount for this reservation
		if($host_penalty_amount > 0)
		{
			$penalty = new HostPenalty;
			$penalty->reservation_id = $reservation->id;
			$penalty->room_id        = $reservation->room_id;
			$penalty->user_id        = $reservation->host_id;
			$penalty->remain_amount  = $host_penalty_amount;
			$penalty->amount         = $host_penalty_amount;
			$penalty->currency_code  = $reservation->currency_code;
			$penalty->status         = 'Pending';
			$penalty->save();
		}

		// Process and Save the host payout amount with host penalty
		if($host_payout_amount > 0)
		{
			// Apply penaly for final host payout amount
			$penalty = HostPenalty::where('user_id',$reservation->host_id)->where('remain_amount','!=',0)->get();
			$penalty_result = $this->check_host_penalty($penalty,$host_payout_amount,$reservation->currency_code);
			$host_amount    = $penalty_result['host_amount'];
			$penalty_id     = $penalty_result['penalty_id'];
			$penalty_amount = $penalty_result['penalty_amount'];

			if(!@$host_payout->id)
			{
				$host_payout->reservation_id = $reservation->id;
				$host_payout->room_id        = $reservation->room_id;
				$host_payout->user_id        = $reservation->host_id;
				$host_payout->user_type      = 'host';
				$host_payout->currency_code  = $reservation->currency_code;
				$host_payout->status         = 'Future';
				$host_payout->save();
			}
			$host_payout->currency_code  = $reservation->currency_code;
			$host_payout->amount         = $host_amount;
			$host_payout->penalty_amount = $penalty_amount;
			$host_payout->penalty_id     = $penalty_id;
			$host_payout->save();
		}
		else if($host_payout) {
			$host_payout->delete();
		}
	}
}

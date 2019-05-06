<?php
/**
 * Created by PhpStorm.
 * User: dmytro
 * Date: 7/25/18
 * Time: 3:40 PM
 */

namespace App\Http\Helper;
use App\Models\Front\Rooms;
use App\Models\Front\SubscribeList;
use Log;

/**
 * Class StripeHelper
 *
 * @package App\Http\Helper
 */
class StripeHelper
{

	function __construct() {
		\Stripe\Stripe::setApiKey(config('services.stripe.secret'));
	}

	/**
	 * Stripe Charge Create
	 *
	 * @param  string $token Stripe Token
	 * @param  Object $plan  Stripe plan
	 *
	 * @return array array
	 */

	public function stripeCharge($token, $plan){
		$data = array();
		try{
			$charge = \Stripe\Charge::create(array(
				"amount" => (($plan->amount *100)),
				"currency" => $plan->currency_code,
				"description" => "subscribe",
				"source" => $token,
			));
			$data['result'] = 'success';
			$data['charge'] = $charge;
		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}

		return $data;
	}

	/**
	 * Stripe Customer Create
	 *
	 * @param int     $room_id Room Id
	 * @param  string $token   Stripe Token
	 *
	 * @return array array
	 */

	public function stripeCustomer($room_id, $token){
		$data = array();
		try{
			$rooms = Rooms::findOrFail($room_id);
			$customer = \Stripe\Customer::create(array(
				"email"     => $rooms->users->email,
				"source"    => $token
			));
			$data['result'] = 'success';
			$data['customer'] = $customer;

		}catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * stripe retrieve customer
	 *
	 * @param int $customer_id customer_id
	 *
	 * return customer object
	 *
	 * @return \Stripe\Customer
	 */

	public function stripeRetrieveCustomer($customer_id) {

		$customer = \Stripe\Customer::retrieve($customer_id);

		return $customer;
	}

	/**
	 * Stripe Card Token Create
	 *
	 * @param  int $card_number card_number
	 * @param  int $card_month  card_month
	 * @param  int $card_year   card_year
	 * @param  int $card_cvv    card_cvv
	 *
	 * return $token object
	 *
	 * @return \Stripe\Token
	 */

	public function stripeToken ($card_number , $card_month, $card_year, $card_cvv){
		$token =\Stripe\Token::create(array(
			"card" => array(
				"number"    => $card_number,
				"exp_month" => $card_month,
				"exp_year"  => $card_year,
				"cvc"       => $card_cvv
			)
		));
		return $token;
	}

	/**
	 * @param $plan
	 *
	 * @return mixed
	 */
	public function stripePlan($plan){
		try{
			$res = \Stripe\Plan::create(
				array(
					"amount" => $plan['amount'],
					"interval" => $plan['interval'],
					"name" => $plan['name'],
					"currency" => $plan['currency'],
					"interval_count" => $plan['interval_count'],
					"trial_period_days" => $plan['trial_period_days'],
					"id" => $plan['id']
				)
			);

			$data['result'] = 'success';
			$data['plan'] = $res;

		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * @param $plan
	 *
	 * @return mixed
	 */
	public function stripePlanUpdate($plan){
		try{
			$p = \Stripe\Plan::retrieve($plan['id']);
			$p->name = $plan['name'];
			$p->trial_period_days = $plan['trial_period_days'];
			$p->active = $plan['active'];
			$res = $p->save();

			$data['result'] = 'success';
		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * @param $coupon
	 *
	 * @return mixed
	 */
	public function stripeCoupon($coupon){
		try{
			$val = [
				"id" => $coupon["id"],
				"name" => $coupon["name"],
				"currency" => $coupon["currency"],
				"duration" => $coupon["duration"],
				"duration_in_months" => $coupon["duration_in_months"],
				"redeem_by" => $coupon["redeem_by"],
			];

			if($coupon["max_redemptions"]) {
				$val["max_redemptions"] = $coupon["max_redemptions"];

			}

			if(isset($coupon["percent_off"])) {
				$val["percent_off"] = $coupon["percent_off"];
			}

			if(isset($coupon["amount_off"])) {
				$val["amount_off"] = $coupon["amount_off"] * 100;
			}

			$res = \Stripe\Coupon::create([$val]);

			$data['result'] = 'success';
			$data['plan'] = $res;

		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * @param $coupon
	 *
	 * @return mixed
	 */
	public function stripeCouponUpdate($coupon){
		try{
			$name = $coupon["name"];
			$coupon = \Stripe\Coupon::retrieve($coupon["id"]);
			$coupon->name = $name;
			$res = $coupon->save();

			$data['result'] = 'success';
		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}



	/**
	 * Stripe Subscription Create
	 *
	 * @param        $customer
	 * @param object $plan   plan
	 * @param string $coupon Coupon_code
	 *
	 * @return array array with subscription and result
	 */

	public function stripeSubscription($customer, $plan, $coupon=null ){
		$data = array();
		try{
			if($plan->trial_days != null) {
				$final_time = strtotime("+".$plan->trial_days." day", time());
			}else{
				//$final_time = strtotime("+" . $plan->days . " day", time());
				$final_time = null;
			}


			if($coupon) {
				$subscription = \Stripe\Subscription::create([
					'customer' => $customer->id,
					'items' => [['plan' => $plan->stripe_plan_code]],
					'trial_end' =>$final_time,
					'coupon' => $coupon,

				]);
			}else{
				$subscription = \Stripe\Subscription::create([
					'customer' => $customer->id,
					'items' => [['plan' => $plan->stripe_plan_code]],
					'trial_end' =>$final_time,
				]);
			}
			$data['result'] = 'success';
			$data['subscription'] = $subscription;
		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * @param      $roomsList
	 * @param      $customer
	 * @param      $plan
	 * @param null $coupon
	 *
	 * @return array
	 */
	public function stripeRoomSubscriptions($room, $customer, $plan, $coupon=null ){
		$data = array();
		try{
			if($plan->trial_days != null) {
				$final_time = strtotime("+365 day", time());
			}else{
//				$final_time = strtotime("+" . $plan->days . " day", time());
				$final_time = null;
			}
			$items = [];
			$user_id = $room->user_id;
			if($coupon){
				$subscription = \Stripe\Subscription::create([
					'customer' => $customer->id,
					'metadata' => ['user_id' => $user_id, 'listing' => $room->id, 'listing_nane' => $room->name],
					'items' => [['plan' => $plan->stripe_plan_id, "quantity" => 1]],
					'trial_end' =>$final_time,
					'coupon' => $coupon
					
				]);
			}
			else{
				$subscription = \Stripe\Subscription::create([
					'customer' => $customer->id,
					'metadata' => ['user_id' => $user_id, 'listing' => $room->id, 'listing_nane' => $room->name],
					'items' => [['plan' => $plan->stripe_plan_id, "quantity" => 1]],
					'trial_end' =>$final_time,
	
				]);
			}
			
			
			$data['result'] = 'success';
			$data['subscription'] = $subscription;
		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * Stripe Subscription retrieve
	 *
	 * @param string $subscription_id Subscription_id
	 *
	 * @return \Stripe\Subscription object
	 */

	public function stripeSubscriptionRetrieve($subscription_id){
		$subscription = \Stripe\Subscription::retrieve($subscription_id);
		return $subscription;
	}

	/**
	 * Stripe Subscription Update
	 *
	 * @param string    $subscription_id    Subscription_id
	 *
	 *  @return subscription object
	 */

	public function stripeSubscriptionUpdate($subscription_id){

		try{
			$subscription = \Stripe\Subscription::update($subscription_id, [
				'trial_end' => 'now',
				'billing_cycle_anchor' => 'now'
			]);
			$data['result'] = 'success';
			$data['subscription'] = $subscription;

		} catch (\Exception $e){
			$data['result'] = 'failed';
			$data['error'] = $e->getMessage();
		}
		return $data;
	}

	/**
	 * Stripe Subscription Resume
	 *
	 * @param string  $subscription_id Subscription_id
	 * @param  string $plan            stripe_plan_code
	 *
	 * @return bool object
	 */

	public function stripeSubscriptionResume($subscription_id, $plan){
		$subscription  = $this->stripeSubscriptionRetrieve($subscription_id);
		\Stripe\Subscription::update($subscription_id, [
			'cancel_at_period_end' => false,
			'items' => [
				[
					'id' => $subscription->items->data[0]->id,
					'plan' => $plan,
				],
			],
		]);
		return true;

	}
}
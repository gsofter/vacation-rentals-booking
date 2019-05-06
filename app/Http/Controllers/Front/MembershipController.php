<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Front\Membershiptype;
use App\Models\Front\Subscriptions;
use App\Models\Front\User;
use Braintree_ClientToken;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use App\Models\Front\Rooms;
use App\Models\Front\RoomsApprovedStatus;
use App\Models\Front\SubscribeList;
use Auth;
class MembershipController extends Controller
{
    public $apiContext;
    //
    public function __construct()
    {
    /** PayPal api context **/
            $paypal_conf = \Config::get('paypal');
            $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
            );
            $this->apiContext->setConfig($paypal_conf['settings']);
            // dd($paypal_conf, $this->apiContext);
    }
    public function paypal_createplan(Request $request){
        // var_dump($request->roomId);exit;
        // var_dump($request->planId);exit;
        $type = Membershiptype::find($request->planId);
        $plan = new Plan();
        $plan->setName('Membership Plan for ' . $type->Name)
            ->setDescription('Vacation Rentals Membership')
            ->setType('fixed');
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency('Year')
            ->setFrequencyInterval("1")
            ->setCycles("2")
            ->setAmount(new Currency(array('value' => intval($type->annual_fee), 'currency' => 'USD')));
 
        $merchantPreferences = new MerchantPreferences();
        $baseUrl = url('/');
        $merchantPreferences->setReturnUrl("$baseUrl/ExecuteAgreement.php?success=true")
            ->setCancelUrl("$baseUrl/ExecuteAgreement.php?success=false")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");
            // ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));
        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        $request = clone $plan;
        try {
            $output = $plan->create($this->apiContext);
        } catch (Exception $ex) {
            ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
            exit(1);
        }
        $plan = $output;
        try {
            $patch = new Patch();
            $value = new PayPalModel('{
                   "state":"ACTIVE"
                 }');
            $patch->setOp('replace')
                ->setPath('/')
                ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);
            $plan->update($patchRequest, $this->apiContext);
            $plan = Plan::get($plan->getId(), $this->apiContext);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            ResultPrinter::printError("Updated the Plan to Active State", "Plan", null, $patchRequest, $ex);
            exit(1);
        }
        $createdPlan = $plan;
        $current_date = date("Y-m-d\TG:i:s\Z", strtotime(date('Y-m-d')." +1 day"));
        // dd($current_date);
        $plan = new Plan();
        $plan->setId($createdPlan->getId());
        $agreement = new Agreement();
        $agreement->setName('Vacation Rentals Membership')
            ->setDescription('Vacation Rentals Membership')
            ->setStartDate($current_date);
        
        $agreement->setPlan($plan);
        // Add Payer
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);
        // Add Shipping Address
      
        $request = clone $agreement;
        //dd($agreement);//
        try {
            $agreement = $agreement->create($this->apiContext);
            $approvalUrl = $agreement->getApprovalLink();
            
        } catch (Exception $ex) {
          
            // ResultPrinter::printError("Created Billing Agreement.", "Agreement", null, $request, $ex);
            exit(1);
        }
        $approvalURl = explode('token=', $approvalUrl);

        return $approvalURl[1] ;
        
    }

    public function paypal_excute(Request $request){
        $token = $request->token;
        $roomId = $request->roomId;
        $planId = $request->planId;
        

        $agreement = new \PayPal\Api\Agreement();
        try {
            // ## Execute Agreement
            // Execute the agreement by passing in the token
            $agreement->execute($token, $this->apiContext);
        } catch (Exception $ex) {
            exit(1);
        }
        // ## Get Agreement
        // Make a get call to retrieve the executed agreement details
        
        try {
            $agreement = \PayPal\Api\Agreement::get($agreement->getId(),  $this->apiContext);
        } catch (Exception $ex) {
            exit(1);
        }
         $agreementId = $agreement->getId();
            $params = array('start_date' => date('Y-m-d', strtotime('-15 years')), 'end_date' => date('Y-m-d', strtotime('+5 days')));
            try {
                $result = \PayPal\Api\Agreement::searchTransactions($agreementId, $params, $this->apiContext);
            } catch (Exception $ex) {
                 exit(1);
        }
        // var_dump($agreement, $agreement->getAgreementDetails(), $agreement->getStartDate());exit;
        $room = Rooms::find($roomId);
        // $plan = 
        // $room->stripe_id = $customer->id;
        $room->plan_type = $planId;
        // $room->card_brand = $customer->sources->data[0]->brand;
        // $room->card_last_four = $customer->sources->data[0]->last4;
        // if(isset($subscription->trial_end)) {
        //     $room->trial_ends_at = date('Y-m-d H:i:s', $subscription->trial_end);
        // }
        $room->subscription_start_date = date('Y-m-d H:i:s', strtotime($agreement->getStartDate()));
        $room->subscription_end_date = date('Y-m-d H:i:s', strtotime($agreement->getAgreementDetails()->getFinalPaymentDate()) );
        $room->subscription_days = '365';
        $room->braintree_id = $agreement->getId();
        $room->paypal_email = $agreement->getPayer()->getPayerInfo()->getEmail();
        $room->status = 'Listed';
        $room->save();

        $approved_status = RoomsApprovedStatus::whereRoomId($room->id)->first();
        $approved_status->approved_status = '0';
        $approved_status->save();

        $paymentSubscriptions = new SubscribeList();
        $paymentSubscriptions->room_id = $room->id;
        $paymentSubscriptions->name = 'main';
        $paymentSubscriptions->amount = Membershiptype::find($planId)->annual_fee;
        $paymentSubscriptions->host_id = $room->user_id;
        // $paymentSubscriptions->stripe_customer_id = $customer->id;
        $paymentSubscriptions->status = 'Subscribe';
        // $paymentSubscriptions->stripe_id = $subscription->id;
        // $paymentSubscriptions->stripe_plan =$subscription->plan->id;
        $paymentSubscriptions->quantity = 1;
        $paymentSubscriptions->braintree_id = $agreement->getId();
        $paymentSubscriptions->braintree_plan = $agreement->getPlan()->getId();
        // if(isset($subscription->trial_end)) {
        //     $paymentSubscriptions->trial_ends_at = date( 'Y-m-d H:i:s', $subscription->trial_end );
        // }
        $paymentSubscriptions->currency_code = 'USD';
        $paymentSubscriptions->subscription_days = '365';
        $paymentSubscriptions->subscription_start_date =date('Y-m-d H:i:s', strtotime($agreement->getStartDate()));
        $paymentSubscriptions->subscription_end_date = date('Y-m-d H:i:s',strtotime($agreement->getAgreementDetails()->getFinalPaymentDate()) );
        $paymentSubscriptions->save();

        //Now delete the free subscriptions
        $freeSubscription = SubscribeList::whereStatus('Free')->whereRoomId($room->id)->first();
        if($freeSubscription) {
            $freeSubscription->delete();
        }




        return $agreement->getId();
        // dd($payer->getPayerInfo()->getEmail());
    }
    public function Braintree_token()
    {
        return response()->json([
            'data' => [
                'token' => Braintree_ClientToken::generate()
            ]
        ]);
    }
    public function gettypes(){
        if(Auth::user()){
            $user = User::find(Auth::user()->id);
        }
        
        $membership_types =  Membershiptype::all();
        foreach($membership_types as $key => $mem_type){
            if(Auth::user()){
                if($user->subscriptions->first() && $user->subscriptions->first()->name  == $mem_type->Name  && ($user->paypal_billing_id  || $user->stripe_id)) {
                    $membership_types[$key]['is_active'] = 1;
                }
                else{
                    $membership_types[$key]['is_active'] = 0;                
                }
            }
            else{
                $membership_types[$key]['is_active'] = 0;        
            }
        }
        return array(
            'current_plan' => Auth::user() && $user->subscriptions->first() && ($user->paypal_billing_id  || $user->stripe_id)? $user->subscriptions->first()->name : '',
            'data' => $membership_types
        );
    }
    public function gettype($planId){
        return Membershiptype::find($planId);
        dd($planId);
    }
    public function stripe(Request $request){
        $user = User::find(Auth::user()->id);
        $planId = $request->planId;
        $type = Membershiptype::find($planId);
        if(($user->braintree_id || $user->stripe_id) && $user->subscriptions->first()->name && $user->subscriptions->first()->stripe_id){
            $user->subscription($user->subscriptions->first()->name)->cancel();
        }

        $user->newSubscription($type->Name, $type->Name)->create($request->stripe_token);
        return array('status' => 'success', 'message' => 'Subscribe Successfully!');
        if ($user->subscribed($type->Name)) {
            //
            
        }
        else{
            return array('status' => 'error', 'message' => 'Subscribe Faild!');
        }
        dd($type->Name,$request);
    }
}

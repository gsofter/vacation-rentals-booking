<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\PaymentGateway;

class PaymentGatewayController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  PaymentGateway 
     * @param: PaymentGateway Add Form Data
     * @return: view-> admin/payment_gateway/index.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            
            $paymentGateway       = PaymentGateway::get();
            return view('admin/payment_gateway/index', compact('paymentGateway'));
            
		}else{
           
            PaymentGateway::where('name', 'username')
                        ->where('site', 'PayPal')
                        ->update(['value' => $request->PayPal__username]);                       
            PaymentGateway::where('name', 'password')
                        ->where('site', 'PayPal')
                        ->update(['value' => $request->PayPal__password]);                       
            PaymentGateway::where('name', 'signature')
                        ->where('site', 'PayPal')
                        ->update(['value' => $request->PayPal__signature]);                       
            PaymentGateway::where('name', 'mode')
                        ->where('site', 'PayPal')
                        ->update(['value' => $request->PayPal__mode]);                       
            PaymentGateway::where('name', 'client')
                        ->where('site', 'PayPal')
                        ->update(['value' => $request->PayPal__client]);                       
            PaymentGateway::where('name', 'secret')
                        ->where('site', 'PayPal')
                        ->update(['value' => $request->PayPal__secret]);  

            PaymentGateway::where('name', 'publish')
                        ->where('site', 'Stripe')
                        ->update(['value' => $request->Stripe__publish]);                       
            PaymentGateway::where('name', 'secret')
                        ->where('site', 'Stripe')
                        ->update(['value' => $request->Stripe__secret]);                       
            PaymentGateway::where('name', 'client_id')
                        ->where('site', 'Stripe')
                        ->update(['value' => $request->Stripe__client_id]);                       
            PaymentGateway::where('name', 'stripe_webhook_secret')
                        ->where('site', 'Stripe')
                        ->update(['value' => $request->Stripe__stripe_webhook_secret]);                       
                              
                     
            
            return redirect()->route('admin.payment_gateway')
                    ->with('success','Submit Payment Gateway Successfully!');
			
		}
    }
   
}
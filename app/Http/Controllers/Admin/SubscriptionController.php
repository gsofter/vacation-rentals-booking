<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Subscription;
use App\Models\admin\Currency;
use App\Models\admin\SubscribeList;
use App\Models\admin\PaymentGateway;
use App\Models\admin\Rooms;

class SubscriptionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //////////////////////////////////////////////////////////////////////////
    ////////////////////////Subscription free Action//////////////////////////
    //////////////////////////////////////////////////////////////////////////

    /**
     * @des: Manage  Subscription free
     * @param: 
     * @return: view-> admin/subscriptions_free/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function free_index()
    {           
        $data = SubscribeList::get();        
        return view('admin/subscriptions_free/index', compact('data'));
        
    }

   
    /**
     * @des: update  Subscription free
     * @param: Subscription free Edit Form Data
     * @return: view-> admin/subscriptions_free/edit.blade.php  ///////   view-> admin/subscriptions_free/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function free_detail(Request $request)
	{
		if(!$_POST){            
           
			$subscribelist       = SubscribeList::find($request->id);	
            return view('admin/subscriptions_free/detail', compact('subscribelist'));
            
		}
		
    }

//////////////////////////////////////////////////////////////////////////
////////////////////////Subscription plan Action//////////////////////////
//////////////////////////////////////////////////////////////////////////


    /**
     * @des: Manage  Subscription plan
     * @param: 
     * @return: view-> admin/subscriptions_plan/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function plan_index()
    {           
        $data = Subscription::get();        
        return view('admin/subscriptions_plan/index', compact('data'));
        
    }

    /**
     * @des: add  Subscription plan 
     * @param: Subscription plan Add Form Data
     * @return: view-> admin/subscriptions_plan/add.blade.php  ///////  view-> admin/subscriptions_plan/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function plan_add(Request $request)
	{
        if(!$_POST){
            $currencies = Currency::where('status', 'Active')->get();           
            return view('admin/subscriptions_plan/add', compact('currencies'));
            
		}else{
           
            $subscription                       = new Subscription;
            
            $subscription->plan_type            = $request->plan_type; 

            $subscription->name                 = $request->name;  
            $subscription->stripe_plan_code     = $request->stripe_plan_code;  
            $subscription->braintree_plan_code  = $request->braintree_plan_code;  
            $subscription->trial_days           = $request->trial_days;  
            $subscription->currency_code        = $request->currency_code;  
            $subscription->amount               = $request->amount;  

            $subscription->days                 = (int)$request->days * (int)$request->period; 

            $subscription->images               = $request->images;  
            $subscription->status               = $request->status;
                  
            $subscription->save();           
            
            return redirect()->route('admin.subscriptions_plan')
                    ->with('success','New  subscription plan Added!');
			
		}
    }
        

    /**
     * @des: update  Subscription plan
     * @param: Subscription plan Edit Form Data
     * @return: view-> admin/subscriptions_plan/edit.blade.php  ///////   view-> admin/subscriptions_plan/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function plan_update(Request $request)
	{
		if(!$_POST){
            
            $currencies = Currency::where('status', 'Active')->get();      
			$subscription       = Subscription::find($request->id);	
            return view('admin/subscriptions_plan/edit', compact('currencies', 'subscription'));
            
		}else{		           
           
            $subscription                       = Subscription::find($request->id);
            
            $subscription->plan_type            = $request->plan_type; 

            $subscription->name                 = $request->name;  
            $subscription->stripe_plan_code     = $request->stripe_plan_code;  
            $subscription->braintree_plan_code  = $request->braintree_plan_code;  
            $subscription->trial_days           = $request->trial_days;  
            $subscription->currency_code        = $request->currency_code;  
            $subscription->amount               = $request->amount;  

            $subscription->days                 = (int)$request->days * (int)$request->period; 

            $subscription->images               = $request->images;  
            $subscription->status               = $request->status;
                  
            $subscription->save();           
            
            return redirect()->route('admin.subscriptions_plan')
                    ->with('success','subscription plan Updated!');
			
		}
		
    }

}
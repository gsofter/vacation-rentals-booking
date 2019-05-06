<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Referrals;
use App\Models\admin\Referralsetting;

class ReferralsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: Manage  referrals 
     * @param: 
     * @return: view-> admin/referrals/referrals.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function referrals()
    {           
        $data = Referrals::get()->groupBy('user_id'); 
                 
        return view('admin/referrals/index', compact('data'));
        
    }

    /**
     * @des: details  referrals 
     * @param: User Edit Form Data
     * @return: view-> admin/referrals/details.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function details($id){

        $data = Referrals::where('user_id', $id)->get();   

        return view('admin/referrals/details', compact('data'));

    }

    /**
     * @des: add  referrals 
     * @param: User Add Form Data
     * @return: view-> admin/referrals/add.blade.php  ///////  view-> admin/referrals/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function add(Request $request)
	{
		if(!$_POST){

			$referrals = $referrers = User::get(['id', 'email']);
            return view('admin.referrals.add', compact('referrals', 'referrers'));
            		
		}else{       

            if($request->user_id == $request->friend_id){
                return back()->with('error','Must be dismatched between Refrrer and Refferal!');
            }
            $currency_code              = Referralsetting::where('name', 'currency_code')->first()->value;
            $per_user_limit             = Referralsetting::where('name', 'per_user_limit')->first()->value;
            $if_friend_guest_credit     = Referralsetting::where('name', 'if_friend_guest_credit')->first()->value;
            $if_friend_host_credit      = Referralsetting::where('name', 'if_friend_host_credit')->first()->value;
            $new_referral_user_credit   = Referralsetting::where('name', 'new_referral_user_credit')->first()->value;
            if($request->credited_amount > $per_user_limit){
                return back()->with('error','Credited amount must be less than '.$per_user_limit.'!');
            }            
           
            $referral                               = new Referrals;  

            $referral->user_id                      = $request->user_id;            
            $referral->friend_id                    = $request->friend_id;            
            $referral->credited_amount              = $request->credited_amount;            
            $referral->status                       = $request->status;            
            $referral->currency_code                = $currency_code;            
            $referral->friend_credited_amount       = 0;            
            $referral->if_friend_guest_amount       = $if_friend_guest_credit;            
            $referral->if_friend_host_amount        = $if_friend_host_credit;            
            $referral->creditable_amount            = $new_referral_user_credit;            

            $referral->save();
            
            return redirect()->route('admin.referrals')
                    ->with('success','New referrals Added!');
			
		}
    }    
   
    /**
     * @des: update  referrals 
     * @param: referrals Edit Form Data
     * @return: view-> admin/referrals/edit.blade.php  ///////   view-> admin/referrals/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function update(Request $request)
	{
		if(!$_POST){

            $referrals = $referrers = User::get(['id', 'email']);           
			$referral   = Referrals::find($request->id);                       
            return view('admin/referrals/edit', compact('referral', 'referrals', 'referrers'));
            
		}else{
			           
            if($request->user_id == $request->friend_id){
                return back()->with('error','Must be dismatched between Refrrer and Refferal!');
            }
            $currency_code              = Referralsetting::where('name', 'currency_code')->first()->value;
            $per_user_limit             = Referralsetting::where('name', 'per_user_limit')->first()->value;
            $if_friend_guest_credit     = Referralsetting::where('name', 'if_friend_guest_credit')->first()->value;
            $if_friend_host_credit      = Referralsetting::where('name', 'if_friend_host_credit')->first()->value;
            $new_referral_user_credit   = Referralsetting::where('name', 'new_referral_user_credit')->first()->value;
            if($request->credited_amount > $per_user_limit){
                return back()->with('error','Credited amount must be less than '.$per_user_limit.'!');
            }            
           
            $referral                               = Referrals::find($request->id);  

            $referral->user_id                      = $request->user_id;            
            $referral->friend_id                    = $request->friend_id;            
            $referral->credited_amount              = $request->credited_amount;            
            $referral->status                       = $request->status;            
            $referral->currency_code                = $currency_code;            
            $referral->friend_credited_amount       = 0;            
            $referral->if_friend_guest_amount       = $if_friend_guest_credit;            
            $referral->if_friend_host_amount        = $if_friend_host_credit;            
            $referral->creditable_amount            = $new_referral_user_credit;            

            $referral->save();                        

            return redirect()->route('admin.referrals')
                    ->with('success','referrals Updated!');
			
		}
		
    }

    
    



}
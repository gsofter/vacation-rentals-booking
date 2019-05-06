<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\ReferralSettings;
use App\Models\admin\Currency;

class ReferralSettingsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  Referral Settings Type 
     * @param: ReferralSettings Add Form Data
     * @return: view-> admin/referral_settings/add.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            $currencies             = Currency::where('status','Active')->get();
            $referralsettings       = ReferralSettings::get();
            return view('admin/referral_settings/index', compact('currencies', 'referralsettings'));
            
		}else{
           
            ReferralSettings::where('name', 'per_user_limit')
                        ->update(['value' => $request->per_user_limit]);
            ReferralSettings::where('name', 'if_friend_guest_credit')
                        ->update(['value' => $request->if_friend_guest_credit]);
            ReferralSettings::where('name', 'if_friend_host_credit')
                        ->update(['value' => $request->if_friend_host_credit]);
            ReferralSettings::where('name', 'new_referral_user_credit')
                        ->update(['value' => $request->new_referral_user_credit]);
            ReferralSettings::where('name', 'currency_code')
                        ->update(['value' => $request->currency_code]);            
            
            return redirect()->route('admin.referral_settings')
                    ->with('success','Submit ReferralSettings Successfully!');
			
		}
    }
   
    



}
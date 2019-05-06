<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Fees;
use App\Models\admin\Currency;

class FeesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  Referral Settings Type 
     * @param: Fees Add Form Data
     * @return: view-> admin/fees/add.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            $currencies         = Currency::where('status','Active')->get();
            $fee                = Fees::where('name', 'discount_percentage')->first();
            return view('admin/fees/index', compact('currencies', 'fee'));
            
		}else{
           
            Fees::where('name', 'discount_percentage')
                        ->update(['value' => $request->discount_percentage]);
           
            
            return redirect()->route('admin.fees')
                    ->with('success','Submited  Fees successfully!');
			
		}
    }
   
    



}
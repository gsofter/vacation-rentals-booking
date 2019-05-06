<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\CouponCode;
use App\Models\admin\Currency;
use App\Models\admin\Language;

class CouponCodeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
    }



    /**
     * @des: Manage  coupon 
     * @param: 
     * @return: view-> admin/coupon/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function coupon()
    {           
        $data = CouponCode::get();        
        return view('admin/coupon/index', compact('data'));
        
    }

    /**
     * @des: add  coupon 
     * @param: coupon Add Form Data
     * @return: view-> admin/coupon/add.blade.php  ///////  view-> admin/coupon/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function add(Request $request)
	{
        if(!$_POST){

			$currencys           = Currency::where('status','Active')->get();
            $coupon_currency     = Currency::where('default_currency','1')->first()->id;       
		
			return view('admin/coupon/add', compact('currencys', 'coupon_currency'));
		}else{
           
            $couponcode                         = new CouponCode;
            
            $couponcode->description            = $request->description;
            
            // $couponcode->braintree_coupon_code  = $request->braintree_coupon_code;
            $couponcode->amount                 = $request->amount;
            $couponcode->type                   = $request->type;
            $couponcode->duration               = $request->duration;
            $couponcode->duration_in_months     = $request->duration_in_months;
            $couponcode->max_redemptions        = $request->max_redemptions;
            $couponcode->currency_code          = $request->currency_code;
            $couponcode->expired_at             = $request->expired_at;
            $couponcode->status                 = $request->status;            
            
            $coupon_code = \Stripe\Coupon::create([
                "percent_off" => $couponcode->amount,
                "duration" => $couponcode->duration,
                // "duration_in_months" => 3,
                "id" => $this->slugify($request->description)
              ]);
            //   dd($coupon_code);
              $couponcode->stripe_coupon_code     = $coupon_code->id;
            $couponcode->save();           
            
            return redirect()->route('admin.coupon')
                    ->with('success','New couponcode Added!');
			
		}
    }
    public   function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
    
      // trim
      $text = trim($text, '-');
    
      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);
    
      // lowercase
      $text = strtolower($text);
    
      if (empty($text)) {
        return 'n-a';
      }
    
      return $text;
    }

    /**
     * @des: update  coupon 
     * @param: coupon Edit Form Data
     * @return: view-> admin/coupon/edit.blade.php  ///////   view-> admin/coupon/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$couponcode     = CouponCode::find($request->id);		
            $currencys      = Currency::where('status','Active')->get();
            return view('admin/coupon/edit', compact('couponcode', 'currencys'));
            
		}else{		           
           
            $couponcode                         = CouponCode::find($request->id);
            
            $couponcode->description            = $request->description;
            $couponcode->stripe_coupon_code     = $request->stripe_coupon_code;
            // $couponcode->braintree_coupon_code  = $request->braintree_coupon_code;
            $couponcode->amount                 = $request->amount;
            $couponcode->type                   = $request->type;
            $couponcode->duration               = $request->duration;
            $couponcode->duration_in_months     = $request->duration_in_months;
            $couponcode->max_redemptions        = $request->max_redemptions;
            $couponcode->currency_code          = $request->currency_code;
            $couponcode->expired_at             = $request->expired_at;
            $couponcode->status                 = $request->status;            

            $couponcode->save();                       
           
            return redirect()->route('admin.coupon')
                    ->with('success','couponcode Updated!');
			
		}
		
    }

    /**
     * @des: delete  coupon 
     * @param: delete
     * @return: view-> admin/coupon/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function delete(Request $request){

        CouponCode::find($request->did)->delete();
        return redirect()->route('admin.coupon')
                ->with('success','couponcode Deleted!');
    }
    



}
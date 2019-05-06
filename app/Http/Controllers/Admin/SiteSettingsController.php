<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Currency;
use App\Models\admin\Language;
use App\Models\admin\Dateformats;
use App\Models\admin\SiteSettings;

class SiteSettingsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  SiteSettings 
     * @param: SiteSettings Add Form Data
     * @return: view-> admin/site_settings/index.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            
            $siteSettings       = SiteSettings::where('flag', '!=', '0')->get();
            $dateFormats        = Dateformats::where('status', 'Active')->get();
            $currencies         = Currency::where('status', 'Active')->get();
            $languages          = Language::where('status', 'Active')->get();
            $paypalCurrencies   = Currency::where(['status' => 'Active', 'paypal_currency' => 'Yes'])->get();

            $default_currency = Currency::where('default_currency', '1')->first()->id;
            $default_language = Language::where('default_language', '1')->first()->id;
            return view('admin/site_settings/index', compact('siteSettings', 'dateFormats', 'languages', 'currencies', 'paypalCurrencies', 'default_currency' ,'default_language'));
            
		}else{
           
            SiteSettings::where('name', 'site_name')                        
                        ->update(['value' => $request->site_name]);
            SiteSettings::where('name', 'head_code')                        
                        ->update(['value' => $request->head_code]); 
            SiteSettings::where('name', 'currency_provider')                        
                        ->update(['value' => $request->currency_provider]); 
            SiteSettings::where('name', 'paypal_currency')                        
                        ->update(['value' => $request->paypal_currency]);   
            SiteSettings::where('name', 'default_home')                        
                        ->update(['value' => $request->default_home]);   
            SiteSettings::where('name', 'version')                        
                        ->update(['value' => $request->version]);   
            SiteSettings::where('name', 'admin_prefix')                        
                        ->update(['value' => $request->admin_prefix]);   
            SiteSettings::where('name', 'site_date_format')                        
                        ->update(['value' => $request->site_date_format]);   


            $orginal_favicon 		      = $request->orginal_favicon;
            if( $uploadimage			  = $request->file('favicon')) {			
                $file_name 				  = 'favicon'.time() .'.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/logos'), $file_name);
                $orginal_favicon 		      = $file_name;
            }
            SiteSettings::where('name', 'favicon')                        
                        ->update(['value' => $orginal_favicon]);  

            $orginal_logo 		          = $request->orginal_logo;
            if( $uploadimage			  = $request->file('logo')) {			
                $file_name 				  = 'logo'.time() .'.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/logos'), $file_name);
                $orginal_logo 		      = $file_name;
            }
            SiteSettings::where('name', 'logo')                        
                        ->update(['value' => $orginal_logo]);  

            $orginal_email_logo 		  = $request->orginal_email_logo;
            if( $uploadimage			  = $request->file('email_logo')) {			
                $file_name 				  = 'email_logo'.time() .'.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/logos'), $file_name);
                $orginal_email_logo 		      = $file_name;
            }
            SiteSettings::where('name', 'email_logo')                        
                        ->update(['value' => $orginal_email_logo]);
       
            $orginal_help_page_cover_image= $request->orginal_help_page_cover_image;
            if( $uploadimage			  = $request->file('help_page_cover_image')) {			
                $file_name 				  = 'help_page_cover_image'.time() .'.' . $uploadimage->getClientOriginalExtension();               
                $uploadimage->move(public_path('images/logos'), $file_name);
                $orginal_help_page_cover_image 		      = $file_name;
            }
            SiteSettings::where('name', 'help_page_cover_image')                        
                        ->update(['value' => $orginal_help_page_cover_image]);  

            
            Currency::where('default_currency', '1')                        
                        ->update(['default_currency' => '0']);   
            Currency::where('id', $request->default_currency)                        
                        ->update(['default_currency' => '1']);   
            
            Language::where('default_language', '1')                        
                        ->update(['default_language' => '0']);   
            Language::where('id', $request->default_language)                        
                        ->update(['default_language' => '1']);   
                        
            return redirect()->route('admin.site_settings')
                    ->with('success','Submit Site Settings Successfully!');
			
		}
    }
   
}
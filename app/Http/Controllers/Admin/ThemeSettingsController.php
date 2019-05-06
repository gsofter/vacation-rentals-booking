<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\ThemeSettings;

class ThemeSettingsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  ThemeSettings 
     * @param: ThemeSettings Add Form Data
     * @return: view-> admin/theme_settings/index.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            
            $themeSettings       = ThemeSettings::get();
            return view('admin/theme_settings/index', compact('themeSettings'));
            
		}else{
           
            ThemeSettings::where('name', 'body_bg_color')                        
                        ->update(['value' => $request->body_bg_color]);   
            
            ThemeSettings::where('name', 'body_font_color')                        
                        ->update(['value' => $request->body_font_color]);   
            
            ThemeSettings::where('name', 'body_font_size')                        
                        ->update(['value' => $request->body_font_size]);   
            
            ThemeSettings::where('name', 'header_bg_color')                        
                        ->update(['value' => $request->header_bg_color]);   
            
            ThemeSettings::where('name', 'footer_bg_color')                        
                        ->update(['value' => $request->footer_bg_color]);   
            
            ThemeSettings::where('name', 'href_color')                        
                        ->update(['value' => $request->href_color]);   
            
            ThemeSettings::where('name', 'primary_btn_color')                        
                        ->update(['value' => $request->primary_btn_color]);               
            
            
            return redirect()->route('admin.theme_settings')
                    ->with('success','Submit Theme Settings Successfully!');
			
		}
    }
   
}
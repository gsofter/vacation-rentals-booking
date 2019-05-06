<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\JoinUs;

class JoinUsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  JoinUs 
     * @param: JoinUs Add Form Data
     * @return: view-> admin/join_us/index.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            
            $joinUs       = JoinUs::get();
            return view('admin/join_us/index', compact('joinUs'));
            
		}else{
           
            JoinUs::where('name', 'facebook')                        
                        ->update(['value' => $request->facebook]);   
                     
            JoinUs::where('name', 'google_plus')                        
                        ->update(['value' => $request->google_plus]);   
                     
            JoinUs::where('name', 'twitter')                        
                        ->update(['value' => $request->twitter]);   
                     
            JoinUs::where('name', 'linkedin')                        
                        ->update(['value' => $request->linkedin]);   
                     
            JoinUs::where('name', 'pinterest')                        
                        ->update(['value' => $request->pinterest]);   
                     
            JoinUs::where('name', 'youtube')                        
                        ->update(['value' => $request->youtube]);   
                     
            JoinUs::where('name', 'instagram')                        
                        ->update(['value' => $request->instagram]);   
                     
            
            return redirect()->route('admin.join_us')
                    ->with('success','Submit Join Us Link Successfully!');
			
		}
    }
   
}
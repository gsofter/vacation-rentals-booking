<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\PropertyManager;

class PropertyManagerController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Property manager 
     * @param: 
     * @return: view-> admin/property_manager/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function index()
    {           
        $data = PropertyManager::get();        
        return view('admin/property_manager/index', compact('data'));
        
    }

    /**
     * @des: add  Property manager 
     * @param: Property manager Add Form Data
     * @return: view-> admin/property_manager/add.blade.php  ///////  view-> admin/property_manager/index.blade.php
     * @dev: Artemova
     * @date:2019/10/14 
    */
    public function add(Request $request)
	{
        
        $user = User::where('email', $request->property_email)->first();
        if($user){
            $exist_email= PropertyManager::where('email',$request->property_email)->first();
            if($exist_email){
                return redirect()->route('admin.property_manager')
                    ->with('error','Already registered user!');
            }else{

                $access_code = mt_rand(100000, 999999);
			
                $exist_chk = PropertyManager::where('access_code',$access_code)->first();
                
                if($exist_chk)
                {
                    $access_code = mt_rand(100000, 999999);
                }
                
                $property_manager = new PropertyManager;			
                
                $property_manager->user_id          = $user->id;			
                $property_manager->email            = $request->property_email;
                $property_manager->access_code      = $access_code;
                $property_manager->save();
                return redirect()->route('admin.property_manager')
                    ->with('success','Property Manager Added Successfully!');
            }
            
    

        }else{
            return redirect()->route('admin.property_manager')
                ->with('error','There is no user!');
        }
		
    }
        

    


}
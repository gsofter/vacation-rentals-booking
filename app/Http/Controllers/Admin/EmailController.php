<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Mail;

use App\Models\admin\EmailSettings;

class EmailController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  EmailSettings 
     * @param: EmailSettings Add Form Data
     * @return: view-> admin/email_settings/index.blade.php  
     * @dev: Artemova
     * @date:2019/10/18
    */
    public function index(Request $request)
	{
        if(!$_POST){
            
            $emailSettings       = EmailSettings::get();
           
            return view('admin/email_settings/index', compact('emailSettings'));
            
		}else{
           
            EmailSettings::where('name', 'driver')                        
                        ->update(['value' => $request->driver]);
            EmailSettings::where('name', 'host')                        
                        ->update(['value' => $request->host]);
            EmailSettings::where('name', 'port')                        
                        ->update(['value' => $request->port]);
            EmailSettings::where('name', 'from_address')                        
                        ->update(['value' => $request->from_address]);
            EmailSettings::where('name', 'from_name')                        
                        ->update(['value' => $request->from_name]);
            EmailSettings::where('name', 'encryption')                        
                        ->update(['value' => $request->encryption]);
            EmailSettings::where('name', 'username')                        
                        ->update(['value' => $request->username]);
            EmailSettings::where('name', 'password')                        
                        ->update(['value' => $request->password]);
            EmailSettings::where('name', 'domain')                        
                        ->update(['value' => $request->domain]);
            EmailSettings::where('name', 'secret')                        
                        ->update(['value' => $request->secret]);
            
           
            return redirect()->route('admin.email_settings')
                    ->with('success','Submit Email Settings Successfully!');
			
		}
    }

    /**
     * @des: add  Send Email 
     * @param: Send Email Add Form Data
     * @return: view-> admin/email_settings/send.blade.php  
     * @dev: Artemova
     * @date:2019/10/18
    */
    public function send_email(Request $request){
        if(!$_POST){
            return view('admin/email_settings/send');
        }else{
            $selectuser = $request->selectuser;
            dd($selectuser);
        }
    }
   
}
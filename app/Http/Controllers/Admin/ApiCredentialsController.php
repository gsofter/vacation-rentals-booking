<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\ApiCredentials;

class ApiCredentialsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * @des: add  ApiCredentials 
     * @param: ApiCredentials Add Form Data
     * @return: view-> admin/api_credentials/index.blade.php  
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index(Request $request)
	{
        if(!$_POST){
            
            $apiCredentials       = ApiCredentials::get();
            return view('admin/api_credentials/index', compact('apiCredentials'));
            
		}else{
           
            ApiCredentials::where('name', 'client_id')
                        ->where('site', 'Facebook')
                        ->update(['value' => $request->Facebook__client_id]);                       
            ApiCredentials::where('name', 'client_secret')
                        ->where('site', 'Facebook')
                        ->update(['value' => $request->Facebook__client_secret]);
                       
            ApiCredentials::where('name', 'client_id')
                        ->where('site', 'Google')
                        ->update(['value' => $request->Google__client_id]);                       
            ApiCredentials::where('name', 'client_secret')
                        ->where('site', 'Google')
                        ->update(['value' => $request->Google__client_secret]);
                       
            ApiCredentials::where('name', 'client_id')
                        ->where('site', 'LinkedIn')
                        ->update(['value' => $request->LinkedIn__client_id]);                       
            ApiCredentials::where('name', 'client_secret')
                        ->where('site', 'LinkedIn')
                        ->update(['value' => $request->LinkedIn__client_secret]);
                       
            ApiCredentials::where('name', 'key')
                        ->where('site', 'GoogleMap')
                        ->update(['value' => $request->GoogleMap__key]);                       
            ApiCredentials::where('name', 'server_key')
                        ->where('site', 'GoogleMap')
                        ->update(['value' => $request->GoogleMap__server_key]);
                       
            ApiCredentials::where('name', 'key')
                        ->where('site', 'Nexmo')
                        ->update(['value' => $request->Nexmo__key]);                       
            ApiCredentials::where('name', 'secret')
                        ->where('site', 'Nexmo')
                        ->update(['value' => $request->Nexmo__secret]);                       
            ApiCredentials::where('name', 'from')
                        ->where('site', 'Nexmo')
                        ->update(['value' => $request->Nexmo__from]);
                       
            ApiCredentials::where('name', 'cloudinary_name')
                        ->where('site', 'Cloudinary')
                        ->update(['value' => $request->Cloudinary__cloudinary_name]);
            ApiCredentials::where('name', 'cloudinary_key')
                        ->where('site', 'Cloudinary')
                        ->update(['value' => $request->Cloudinary__cloudinary_key]);
            ApiCredentials::where('name', 'cloudinary_secret')
                        ->where('site', 'Cloudinary')
                        ->update(['value' => $request->Cloudinary__cloudinary_secret]);
            ApiCredentials::where('name', 'cloud_base_url')
                        ->where('site', 'Cloudinary')
                        ->update(['value' => $request->Cloudinary__cloud_base_url]);
            ApiCredentials::where('name', 'cloud_secure_url')
                        ->where('site', 'Cloudinary')
                        ->update(['value' => $request->Cloudinary__cloud_secure_url]);
            ApiCredentials::where('name', 'cloud_api_url')
                        ->where('site', 'Cloudinary')
                        ->update(['value' => $request->Cloudinary__cloud_api_url]);
                       
            ApiCredentials::where('name', 'sid')
                        ->where('site', 'Twilio')
                        ->update(['value' => $request->Twilio__sid]);
            ApiCredentials::where('name', 'auth_token')
                        ->where('site', 'Twilio')
                        ->update(['value' => $request->Twilio__auth_token]);
            ApiCredentials::where('name', 'from')
                        ->where('site', 'Twilio')
                        ->update(['value' => $request->Twilio__from]);                       
            
            return redirect()->route('admin.api_credentials')
                    ->with('success','Submit Api Credentials Successfully!');
			
		}
    }
   
}
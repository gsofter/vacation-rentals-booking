<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\UsersPhoneNumbers;
use App\Models\admin\Timezone;
use App\Models\admin\Language;

class UsersController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// User Manage Action ///////////////////////////
///////////////////////////////////////////////////////////////////////////////////

    /**
     * @des: Manage  Users 
     * @param: 
     * @return: view-> admin/users/users.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function users()
    {           
        $data = User::get();        
        return view('admin/users/index', compact('data'));
        
    }

    /**
     * @des: add  Users 
     * @param: User Add Form Data
     * @return: view-> admin/users/add.blade.php  ///////  view-> admin/users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function add(Request $request)
	{
		if(!$_POST){
			$languages = Language::where('status','Active')->get();
			$timezones = Timezone::get();
            
			return view('admin/users/add', compact('data', 'languages', 'timezones'));
		}else{
            $lang = "";
            $language = [];
            $language = $request->language;
            if(!empty($language)){
                foreach($language as $l){
                    $lang .= $l . ",";
                }
                $lang = rtrim($lang, ',');
            }               
           
            $user                   = new User;
            
            $user->first_name       = $request->first_name;
            $user->last_name        = $request->last_name;            
            $user->email            = $request->email;           
            $user->password         = bcrypt($request->password);            
            $user->status           = $request->status;
            $user->property_manager = $request->property_manager;
            $user->languages        = $lang;

            if($request->dob)
                $user->dob          = $request->dob;
            if($request->gender)
                $user->gender       = $request->gender;
            if($request->live)
                $user->live         = $request->live;
            if($request->about)
                $user->about        = $request->about;
            if($request->website)
                $user->website      = $request->website;
            if($request->school)
                $user->school       = $request->school;
            else
                $user->school       = "";
            if($request->work)
                $user->work         = $request->work; 
            else
                $user->work         = "";
            if($request->timezone)
                $user->timezone     = $request->timezone;
            else
                $user->timezone     = "";

            $user->save();

            $uid = $user->id;

            $this->addPhonenumberByUserID($request->phone_number, $uid);

            
            return redirect()->route('admin.users')
                    ->with('success','New User Added!');
			
		}
    }
    
    public function addPhonenumberByUserID($pn, $uid){
        UsersPhoneNumbers::where('user_id', '=', $uid)->delete();
        $phone = new UsersPhoneNumbers;
        $phone -> user_id       = $uid;
        $phone -> phone_number  = $pn;
        $phone->save();
    }

    /**
     * @des: update  Users 
     * @param: User Edit Form Data
     * @return: view-> admin/users/edit.blade.php  ///////   view-> admin/users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function update(Request $request)
	{
		if(!$_POST){
			$user  = User::find($request->id);		
            $languages = Language::where('status','Active')->get();
            $timezones = Timezone::get();
            
			return view('admin/users/edit', compact('user', 'languages', 'timezones'));
		}else{
			
            $lang = "";
            $language = [];
            $language = $request->language;
            if(!empty($language)){
                foreach($language as $l){
                    $lang .= $l . ",";
                }
                $lang = rtrim($lang, ',');
            }
                    
           
            $user                   = User::find($request->id);
           
            $user->first_name       = $request->first_name;
            $user->last_name        = $request->last_name;            
            $user->email            = $request->email;           
                 
            $user->status           = $request->status;
            $user->property_manager = $request->property_manager;
            $user->languages        = $lang;

            if($request->password)
                $user->password         = bcrypt($request->password);       
            if($request->dob)
                $user->dob          = $request->dob;
            
            if($request->gender)
                $user->gender       = $request->gender;
            
            if($request->live)
                $user->live         = $request->live;
           
            if($request->about)
                $user->about        = $request->about;
            
            if($request->website)
                $user->website      = $request->website;
           
            if($request->school)
                $user->school       = $request->school;
            
            if($request->work)
                $user->work         = $request->work; 
            
            if($request->timezone)
                $user->timezone     = $request->timezone;
            

            $user->save();

            $this->addPhonenumberByUserID($request->phone_number, $request->id);

            return redirect()->route('admin.users')
                    ->with('success','User Updated!');
			
		}
		
    }

    /**
     * @des: delete  Users 
     * @param: User Edit Form Data
     * @return: view-> admin/users/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function delete(Request $request){
        User::find($request->did)->delete();
        return redirect()->route('admin.users')
                ->with('success','User Deleted!');
    }
    



}
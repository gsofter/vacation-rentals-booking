<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Front\UsersPhoneNumbers;
use App\Models\Front\ProfilePicture;
use App\Models\Front\UsersVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Notifications\UserRegisteredSuccessfully;
use  App\Mail\RegisterSuccessNotification;
use Auth;
use File;
use Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request){
       
        $validator =  Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            "birthday_month" => 'required|string|max:255',
            "birthday_day" => 'required|string|max:255',
            "birthday_year" => 'required|string|max:255',
            "user_type" => 'required|string|max:255' 
            
        ]);
         if($validator->fails()){
            return $validator->errors();
         }
         else{

             $data = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'dob' => $request->birthday_year.'-'.$request->birthday_month.'-'.$request->birthday_day,
                'user_type' => $request->user_type
             );
            $user = User::create($data);
            $user_id = $user->id;

            // 
            $phone_number = new UsersPhoneNumbers();
           
            $phone_number->user_id      = $user->id;
            $phone_number->phone_number = $request->phone_number;
            $phone_number->country_name = 'us';
            $phone_number->status       = 'Null'; //todo-vr update based on request once we integrate sms verification on register
            // 
            $phone_number->save();    //Create phone number record
           
            $user_pic = new ProfilePicture;
            $user_pic->user_id      = $user_id;
			$user_pic->src          = "";
			$user_pic->photo_source = 'Local';
            $user_pic->save();
         
            $user_verification = new UsersVerification;

            $user_verification->user_id =   $user_id;
            $user_verification->save(); 
            // 
            // Mail::to($user->email)->send(new RegisterSuccessNotification($user));
            $result = array('success' => true, 'status_message' => 'Success',"result" => "Success");
            
            return response()->json($result);   
         
            
         }

    }
    public function signupSocial(Request $request){
        $validator =  Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            "birthday_month" => 'required|string|max:255',
            "birthday_day" => 'required|string|max:255',
            "birthday_year" => 'required|string|max:255',
            "user_type" => 'required|string|max:255' 
            
        ]);
         if($validator->fails()){
            return $validator->errors();
         }
         else{
             $data = array(
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'dob' => $request->birthday_year.'-'.$request->birthday_month.'-'.$request->birthday_day,
                'user_type' => $request->user_type,
                'google_id' =>$request->google_id,
                'fb_id' =>$request->fb_id,
                'linkedin_id' =>$request->linkedin_id,
                // 'ip_address' => $_SERVER['RE']

             );
            
            $user = User::create($data);
            $user_id = $user->id;


            $profile_picture = new ProfilePicture();
            $user_verification = new UsersVerification;

		    $user_verification->user_id =   $user_id;

		//Check social request type & set verification
		 
            $profile_picture->user_id = $user_id;
            if($request->avatar){
                $avatar_url = $request->avatar;
                $fileContents = file_get_contents($avatar_url);
                if($request->fb_id){
                     $profile_picture->photo_source = 'Facebook';

                     $user_verification->facebook     =   'yes';
                     $user_verification->fb_id        =   $request->fb_id;
                }
                else if ($request->linkedin_id){
                    $profile_picture->photo_source = 'LinkedIn';
                    $user_verification->linkedin     =   'yes';
			        $user_verification->linkedin_id        =   $request->linkedin_id;
                }
                else if ($request->google_id ){
                    $profile_picture->photo_source = 'Google';
                    $user_verification->google     =   'yes';
			        $user_verification->google_id       =   $request->google_id;
                }
                else{
                    $fileContents = file_get_contents($avatar);
                    $path = public_path() . '/images/users/' . $user_id . "/profile_picture_avatar.jpg";
                    File::put($path, $fileContents);
                    $profile_picture->photo_source = 'Local';
                }
                $profile_picture->src = $avatar_url;
                $profile_picture->save();
               
            }
            if($request->fb_id){
             
                $user_verification->facebook     =   'yes';
                $user_verification->fb_id        =   $request->fb_id;
           }
           else if ($request->linkedin_id){
             
               $user_verification->linkedin     =   'yes';
               $user_verification->linkedin_id        =   $request->linkedin_id;
           }
           else if ($request->google_id ){
              
               $user_verification->google     =   'yes';
               $user_verification->google_id       =   $request->google_id;
           }
           else{
             
           }
            $user_verification->save();
            $phone_number = new UsersPhoneNumbers();
            $phone_number->user_id      = $user->id;
            $phone_number->phone_number = $request->phone_number;

            $phone_number->country_name = $request->phone_code ?? 'us' ;
            $phone_number->status       = 'Null'; //todo-vr update based on request once we integrate sms verification on register
            $phone_number->save();

            Mail::to($user->email)->send(new RegisterSuccessNotification($user));
            if(Auth::loginUsingId($user->id))
            {
                $result = array('success' => true, 'status_message' => 'Success',"result" => "Success");
            }
            else
            {
                $result = array('success' => false, 'status_message' => 'Failed',"result" => "Failed");
            }
            
            return response()->json($result);   
         }

    }
    public function activateUser($id)
    {
        try {
            $user = User::find($id);
            $user -> status = 'Active';
            $user -> save();
            if (!$user) {
                return "The code does not exist for any user in our system.";
            }
            $user_verification = UsersVerification::find($id)      ;
            $user_verification->email = 'yes';
            $user_verification->save();


            auth()->login($user);
        } catch (\Exception $exception) {
            logger()->error($exception);
            return "Whoops! something went wrong.";
        }
        return redirect()->to('/');
    }

}

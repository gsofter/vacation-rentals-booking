<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\AbstractUser;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Front\User;
use Session;
use App\Models\Front\ProfilePicture;
//ProfilePicture
class SocialAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $maxAttempts = 5;

    protected $decayMinutes = 10;

    /**
     * @var \App\Repositories\Contracts\AccountRepository
     */
    protected $account;
 
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password') + ['active' => 1];
    }

    /**
     * Show the application's login form.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        return view('auth.login')
            ->withIsLocked($this->hasTooManyLoginAttempts($request))
            ->withSocialiteLinks(self::getSocialLinks());
    }

    /**
     * Show the application's login form.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function showAdminLoginForm(Request $request)
    {
        return view('auth.admin.login')
            ->withIsLocked($this->hasTooManyLoginAttempts($request));
    }

    /**
     * Generates social login links based on what is enabled.
     *
     * @return string
     */
    private static function getSocialLinks()
    {
        $socialiteLinks = [];
        $socialiteHtml = '';

        foreach (config('services') as $name => $service) {
            if (isset($service['client_id'])) {
                $route = route('social.login', $name);
                $icon = ucfirst($name);

                $socialiteLinks[] = "<a href=\"{$route}\" class=\"btn btn-default btn-{$name}\"><i class=\"fab fa-{$name} fa-lg\"></i> {$icon}</a>";
            }
        }

        foreach ($socialiteLinks as $socialiteLink) {
            $socialiteHtml .= ('' !== $socialiteHtml ? '&nbsp;' : '')
                .$socialiteLink;
        }

        return $socialiteHtml;
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->ip());
    }

    /**
     * Validate the user login request.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ];

        if ($this->hasTooManyLoginAttempts($request)) {
            $rules['g-recaptcha-response'] = ['required', new CaptchaRule()];
        }

        $this->validate($request, $rules);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->clearLoginAttempts($request);
        }
    }

    private function flushSession(Request $request, $redirectTo = 'home')
    {
        if ($admin_id = session()->get('admin_user_id')) {
            // Impersonate mode, back to original User
            session()->forget('admin_user_id');
            session()->forget('admin_user_name');
            session()->forget('temp_user_id');

            auth()->loginUsingId((int) $admin_id);

            return redirect()->route('admin.home');
        }

        // Normal logout
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route($redirectTo);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @throws \RuntimeException
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        return $this->flushSession($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @throws \RuntimeException
     *
     * @return \Illuminate\Http\Response
     */
    public function adminLogout(Request $request)
    {
        return $this->flushSession($request, 'admin.login');
    }

    protected function redirectTo()
    {
        return home_route();
    }

    /**
     * @param                          $provider
     * @param \Illuminate\Http\Request $request
     */
    public function redirectToProvider($provider, Request $request)
    {
        
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param                          $provider
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider, Request $request)
    {	
        /** @var AbstractUser $user */
      
//        dd(Socialite::driver($provider));
        try {	 
    		$user = Socialite::driver($provider)->user();
        	
        } catch (\Exception $e) {
            \Session::flash('error','There is the problem with your login. Please retry again!');
            dd($e);
            // return redirect()->route('login');
        }
	
        //  if(explode("@", $user->email)[1] !== 'company.com'){
        //     return redirect()->to('/');
        // }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();

        if($existingUser){
            // log them indd()
            if($provider == "google")
        	$existingUser->google_id       = $user->id;
        	if($provider == "facebook")
            $existingUser->fb_id        = $user->id;
            if($provider == 'linkedin')
            $existingUser->linkedin_id        = $user->id;
            // $existingUser->google_id  = $userNode->getId();
            $existingUser->save();
            $profile_picture =  ProfilePicture::find($existingUser->id);
            if(!$profile_picture){
                $profile_picture = new ProfilePicture();
                $profile_picture->user_id = $existingUser->id;
            }
            $profile_picture->src = $user->avatar_original;
            if($provider == "google")
            $profile_picture->photo_source = 'Google';
            if($provider == "facebook")
            $profile_picture->photo_source = 'Facebook';
            if($provider == "linkedin")
            $profile_picture->photo_source = 'LinkedIn';
            $profile_picture->save();
            auth()->login($existingUser, true);
        } else {
            // create a new user.
            $ex_name = explode(' ',$user->getName());
            $firstName = $ex_name[0];
            $lastName = @$ex_name[1];
            $newUser                  = new User;
            $newUser->first_name            = $firstName;
            $newUser->last_name            = $lastName;
            $newUser->email           = $user->email;
            if($provider == "google")
        	$newUser->google_id       = $user->id;
        	if($provider == "facebook")
            $newUser->fb_id        = $user->id;
            if($provider == 'linkedin')
            $newUser->linkedin_id        = $user->id;
            $newUser->avatar          = $user->getAvatar();            
        	$newUser->password        = "$2y$10$9OJ8W6epktzUGx7tyJPz6uE2k4oOYG586niZTSIECBy/C3B8f085K";

            $newUser->avatar_original = $user->avatar_original;

            Session::put('social_user_data', $newUser);
            return redirect('users/signup_social');
            // $newUser->save();
            auth()->login($newUser, true);
        }
        return redirect()->to('/');
    }


    public function signup_social(){
		$social_user_data = Session::get('social_user_data');
        // dd($social_user_data->first_name);
        $newUser = array(
            'first_name' => $social_user_data->first_name,
            'last_name' => $social_user_data->last_name,
            'email' => $social_user_data->email,
            'google_id' => $social_user_data->google_id,
            'fb_id' => $social_user_data->fb_id,
            'linkedin_id' => $social_user_data->linkedin_id,
            'avatar_original' => $social_user_data->avatar_original,
            'avatar' => $social_user_data->avatar,
        );
        //last_name
        //email
        //google_id
        //avatar
        //avatar_original

		if(!$social_user_data){
			return redirect('signup_login');
		}
        // $social_user_data->toArray();

		$data['newUser'] = $newUser;
        $data['title'] = 'Log In / Sign Up';
        
		return view('signup_social', $data);
	}
}

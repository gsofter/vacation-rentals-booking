<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Front\Rooms;
use App\Models\Front\Wishlists;
use App\Models\Front\SavedWishlists;
use App\Models\Front\User;
use Mail;
use Auth;
use App;
use App\Http\Start\Helpers;
use App\Http\Controllers\EmailController;

/**
 * Class WishlistController
 *
 * @package App\Http\Controllers
 */
class WishlistController extends Controller
{
    protected $helper; // Global variable for Helpers instance

    public function __construct()
    {
        $this->helper = new Helpers;
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \App\Models\Front\Wishlists[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|string
	 */
	public function wishlist_list(Request $request)
    {
        if(Auth::check()) {
            $result = Wishlists::leftJoin('saved_wishlists', function($join) use($request) {
                                $join->on('saved_wishlists.wishlist_id', '=', 'wishlists.id')->where('saved_wishlists.room_id', '=', $request->id);
                            })->where('wishlists.user_id', Auth::user()->id)->where('wishlists.name','!=','')->orderBy('wishlists.id','desc')->select(['wishlists.id as id', 'name', 'saved_wishlists.id as saved_id'])->get();

    	   return $result;
        }
        else {
            return array();
        }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function create(Request $request)
    {
        $wishlist = new Wishlists;

        $wishlist->name    = $request->data;
        $wishlist->user_id = Auth::user()->id;

        $wishlist->save();

        $result = Wishlists::leftJoin('saved_wishlists', function($join) use($request) {
                                $join->on('saved_wishlists.wishlist_id', '=', 'wishlists.id')->where('saved_wishlists.room_id', '=', $request->id);
                            })->where('wishlists.user_id', Auth::user()->id)->orderBy('wishlists.id','desc')->where('wishlists.name','!=','')->select(['wishlists.id as id', 'name', 'saved_wishlists.id as saved_id'])->get();
        
        return json_encode($result);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function create_new_wishlist(Request $request)
    {
        $wishlist = new Wishlists;

        $wishlist->name    = $request->name;
        $wishlist->privacy = $request->privacy;
        $wishlist->user_id = Auth::user()->id;

        $wishlist->save();

        $this->helper->flash_message('success', trans('messages.wishlist.created_successfully')); // Call flash message function
        return redirect('wishlists/my');
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function edit_wishlist(Request $request)
    {
        $wishlist = Wishlists::find($request->id);

        $wishlist->name    = $request->name;
        $wishlist->privacy = $request->privacy;

        $wishlist->save();

        $this->helper->flash_message('success', trans('messages.wishlist.updated_successfully')); // Call flash message function
        return redirect('wishlists/'.$request->id);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function delete_wishlist(Request $request)
    {
         
        $delete = Wishlists::whereId($request->id)->whereUserId(Auth::user()->id);

        if($delete->count()) {
            $counts=SavedWishlists::whereWishlistId($request->id)->delete();
            $delete->delete();
            $this->helper->flash_message('success', trans('messages.wishlist.deleted_successfully')); // Call flash message function
           $counts=Wishlists::whereId($request->id)->whereUserId(Auth::user()->id)->count();
            if($counts)
            return redirect('wishlists/my');
        else
            return redirect('dashboard');

        }
        else 
            return redirect('dashboard');
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 */
	public function add_note_wishlist(Request $request)
    {
    	SavedWishlists::whereWishlistId($request->id)->whereUserId(Auth::user()->id)->whereRoomId($request->room_id)->update(['note' => $request->note]);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return int|string
	 * @throws \Exception
	 */
	public function save_wishlist(Request $request)
    {
        if($request->saved_id) {
            SavedWishlists::find($request->saved_id)->delete();
            return 'null';
        }
        else {
            $save_wishlist = new SavedWishlists;

            $save_wishlist->room_id     = $request->data;
            $save_wishlist->wishlist_id = $request->wishlist_id;
            $save_wishlist->user_id     = Auth::user()->id;

            $save_wishlist->save();

            return $save_wishlist->id;
        }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return int|string
	 * @throws \Exception
	 */
	public function save_wishlist_experience(Request $request)
    {
        if($request->saved_id) {
            SavedWishlists::find($request->saved_id)->delete();
            return 'null';
        }
        else {
            $save_wishlist = new SavedWishlists;
            $save_wishlist->room_id     = $request->data;
            $save_wishlist->wishlist_id = $request->wishlist_id;
            $save_wishlist->user_id     = Auth::user()->id;
            $save_wishlist->list_type     = 'Experiences';
            $save_wishlist->save();

            return $save_wishlist->id;
        }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \App\Models\Front\SavedWishlists[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 * @throws \Exception
	 */
	public function remove_saved_wishlist(Request $request)
    {
        SavedWishlists::whereWishlistId($request->id)->whereRoomId($request->room_id)->delete();
        return SavedWishlists::whereWishlistId($request->id)->get();
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function my_wishlists(Request $request)
    {
        if(!@$request->id || @Auth::user()->id == $request->id) {
            $data['result'] = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms','host_experiences']);
            }, 'profile_picture'])->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $data['owner'] = 1;
        }
        else {
            $data['result'] = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms','host_experiences']);
            }, 'profile_picture'])->where('user_id', $request->id)->wherePrivacy(0)->orderBy('id', 'desc')->get();
            $data['owner'] = 0;
        }
        
        if($data['result']->count() == 0)
            abort(404);
        

        $wish_count= wishlists::where('user_id',@Auth::user()->id)->where('name','!=','')->get();
        $data['count'] = $wish_count->count();

        return view('wishlists.my_wishlists', $data);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	public function get_wishlists_home(Request $request)
    {
        $check = Wishlists::whereId($request->id)->whereUserId(@Auth::user()->id)->first();
        $wishlist = Wishlists::with([
            'saved_wishlists' => function($query){
                $query->with([
                    'rooms' => function($query){
                        $query->with('rooms_address');
                    },
                    'rooms_photos', 'rooms_price' => function($query){
                        $query->with('currency');
                    }, 
                    'users', 
                    'profile_picture'
                ])->where('list_type', 'Rooms');
        }])->where('id', $request->id);
        if($check) 
        {
            $wishlist =$wishlist->get();
        }
        else 
        {
            $wishlist =$wishlist->where('privacy',0)->get();
        }
        return $wishlist->tojson();
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	public function get_wishlists_experience(Request $request)
    {
        $check = Wishlists::whereId($request->id)->whereUserId(@Auth::user()->id)->first();
        $wishlist = Wishlists::with([
            'saved_wishlists' => function($query){
                $query->with([
                    'host_experiences' => function($query){
                        $query->with('host_experience_location','host_experience_photos','currency','city_details');
                    },
                    'users', 
                    'profile_picture'
                ])->where('list_type', 'Experiences');
        }])->where('id', $request->id);
        if($check) 
        {
            $wishlist =$wishlist->get();
        }
        else 
        {
            $wishlist =$wishlist->where('privacy',0)->get();
        }
        return $wishlist->tojson();
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function wishlist_details(Request $request)
    {
        $check = Wishlists::whereId($request->id)->whereUserId(@Auth::user()->id)->first();
        $wishlist = Wishlists::with([
            'saved_wishlists' => function($query){
                $query->with([
                    'users', 
                    'profile_picture'
                ]);
        }])->where('id', $request->id);
        if($check) 
        {
            $data['owner'] = 1;
            $wishlist =$wishlist->get();
        }
        else 
        {
            $data['owner'] = 0;
            $wishlist =$wishlist->where('privacy',0)->get();
        }
        $data['result']=$wishlist;
        $data['count'] = 0;
        $data['wl_id']=$request->id;
        return view('wishlists.wishlist_details', $data);
    }

	/**
	 * @param \Illuminate\Http\Request              $request
	 * @param \App\Http\Controllers\EmailController $email_controller
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \InvalidArgumentException
	 */
	/**
	 * @param \Illuminate\Http\Request              $request
	 * @param \App\Http\Controllers\EmailController $email_controller
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \InvalidArgumentException
	 */
	/**
	 * @param \Illuminate\Http\Request              $request
	 * @param \App\Http\Controllers\EmailController $email_controller
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \InvalidArgumentException
	 */
	public function share_email(Request $request, EmailController $email_controller)
    {
        $wishlist_id = $request->id;
        $emails      = $request->email;
        $message     = $request->message;

        $ex_email = explode(',', $emails);
        $results  = User::select('email')->get();

        foreach ($results as $row)
            $result[] = $row->email;

        $result      = explode(',', $request->email);
        $emails      = array_filter(array_map('trim', $result));
        $data['url'] = url('/').'/';
        $data['locale']       = App::getLocale();
        $message     = Auth::user()->first_name."'s Wish List Link: ".$data['url'].'wishlists/'.$wishlist_id.' <br><br>'.$message;

        foreach($emails as $email) {
            $user               = User::where('email', $email)->get();
            $data['first_name'] = (@$user[0]->first_name) ? $user[0]->first_name : $email;
            $data['content']    = $message;
            $subject            = Auth::user()->first_name.' shared his Wish List';

            Mail::queue('emails.custom_email', $data, function($message) use($user, $subject, $emails, $email) {
                $message->to((@$user[0]->email) ? $user[0]->email : $email, (@$user[0]->first_name) ? $user[0]->first_name : $email)->subject($subject);
            });
        }

        $this->helper->flash_message('success', trans('messages.wishlist.shared_successfully')); // Call flash message function
        return redirect('wishlists/'.$wishlist_id);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function popular(Request $request)
    {
        $data['result'] = Rooms::wherePopular('Yes')->whereStatus('Listed')->get();

        if(!@$request->id || @Auth::user()->id == $request->id) {
            $result = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms']);
            }, 'profile_picture'])->where('user_id', @Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        else {
            $result = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms']);
            }, 'profile_picture'])->where('user_id', $request->id)->wherePrivacy(0)->orderBy('id', 'desc')->get();
        }
        
        $data['count'] = $result->count();

        return view('wishlists.popular', $data);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function picks(Request $request)
    {
        $data['result'] = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms']);
            }, 'profile_picture'])->wherePrivacy(0)->wherePick('Yes')->orderBy('id', 'desc')->get();

        if(!@$request->id || @Auth::user()->id == $request->id) {
            $result = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms']);
            }, 'profile_picture'])->where('user_id', @Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        else {
            $result = Wishlists::with(['saved_wishlists' => function($query){
                $query->with(['rooms']);
            }, 'profile_picture'])->where('user_id', $request->id)->wherePrivacy(0)->orderBy('id', 'desc')->get();
        }
        
        $data['count'] = $result->count();
        
        return view('wishlists.picks', $data);
    }
}

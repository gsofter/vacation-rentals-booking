<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Front\Messages;
use App\Models\Front\User;
use Auth;
class InboxController extends Controller
{
    //
    public function getUserList(){
        // Messages
        $messages = Messages::all_messages(Auth::user()->id);
        foreach($messages as $key => $message){
            $messages[$key]->sender_userinfo = User::find($message->user_from);
            $messages[$key]->sender_profile_pic = User::find($message->user_from)->profile_picture->src;
        }
        return array(
            'status' => 'success',
            'message' => 'loaded',
            'result' => $messages

        );
    }
    public function message_by_type(Request $request)
    {
        $user_id = Auth::user()->id;
        $type    = trim($request->type);

        if($type == "starred")
        {
            $result =   Messages::whereIn('id', function($query) use($user_id)
                            {   
                                $query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
                            })->with(['user_details' => function($query) {
                                $query->with('profile_picture');
                            }])->with(['reservation' => function($query) {
                                $query->with('currency');
                            }])->with('rooms_address')->where('star', 1)->orderBy('id','desc');
        }
        else if($type == "all")
        {

            $result =   Messages::whereIn('id', function($query) use($user_id)
                            {   
                                $query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
                            })->with(['user_details' => function($query) {
                                $query->with('profile_picture');
                            }])->with(['reservation' => function($query) {
                                $query->with('currency');
                            }])->with('rooms_address')->orderBy('id','desc');

        }
        else if($type == "hidden")
        {
            $result =   Messages::whereIn('id', function($query) use($user_id)
                            {   
                                $query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
                            })->with(['user_details' => function($query) {
                                $query->with('profile_picture');
                            }])->with(['reservation' => function($query) {
                                $query->with('currency');
                            }])->with('rooms_address')->where('archive', 1)->orderBy('id','desc');
        }
        else if($type == "unread")
        {
            $result =   Messages::whereIn('id', function($query) use($user_id)
                            {   
                                $query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
                            })->with(['user_details' => function($query) {
                                $query->with('profile_picture');
                            }])->with(['reservation' => function($query) {
                                $query->with('currency');
                            }])->with('rooms_address')->where('read',0)->orderBy('id','desc');
        }
        else if($type == "reservations")
        {
            $result =   Messages::whereIn('id', function($query) use($user_id)
                            {   
                                $query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
                            })->with(['user_details' => function($query) {
                                $query->with('profile_picture');
                            }])->with(['reservation' => function($query) {
                                $query->with('currency');
                            }])->whereHas('reservation' ,function($query) {
                                $query->where('status','!=','');
                            })->with('rooms_address')->where('reservation_id','!=', 0)->orderBy('id','desc');
        }
        else // Pending Requests
        {
            $result =   Messages::whereIn('id', function($query) use($user_id)
                            {
                                $query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
                            })->with(['user_details' => function($query) {
                                $query->with('profile_picture');
                            },'reservation'=>function($query){
                                $query->with('currency');
                            }])->whereHas('reservation' ,function($query) {
                                $query->where('status','Pending');
                            })->with('rooms_address')->orderBy('id','desc');
        }

        $result->with('host_experience');
        
        $result =  $result->paginate(10)->toJson();

        return $result;
    }
    public function getmessages(){

    }
}

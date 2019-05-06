<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pusher\Laravel\Facades\Pusher;
use Pusher\Laravel\PusherManager;
use App\Models\Front\PusherLog;
class PusherController extends Controller{
    protected $pusher;
    public function __construct(PusherManager $pusher)
    {
        $this->pusher = $pusher;
    }
    public function webhook(Request $request){
        // echo 1;exit;
        // return json_encode($request->events);
        $pusherlog = new PusherLog;
        $pusherlog->time_ms = $request->time_ms;
        $pusherlog->data = json_encode($request->events);
        $pusherlog->hook_type = $request->event;
        
        $pusherlog->save();
        if($request->event == 'channel_existence'){

        }
        if($request->event == 'client_event'){

        }
        if($request->event == 'presence'){

        }
        return $pusherlog;
    }
}
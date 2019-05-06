<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Front\User;
class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message['message'] = $message;
        $this->message['user_id'] = $message->user_id;
        $this->message['message']['url'] = asset($message->url);
        $this->message['user_profile_picture'] = User::find($message->user_id)->profile_picture->src;
        $this->message['sender_profile_picture'] = User::find($message->sender_id)->profile_picture->src;
        //
    //    var_dump($this->message);exit;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['chat_'.$this->message['user_id']];
    }
    
}

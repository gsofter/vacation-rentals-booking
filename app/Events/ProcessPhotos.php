<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class ProcessPhotos
 *
 * @package App\Events
 */
class ProcessPhotos
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_id;
    public $file_names;

	/**
	 * Create a new event instance.
	 *
	 * @param $room_id
	 * @param $file_names
	 */
    public function __construct($room_id, $file_names)
    {
        //
        $this->room_id = $room_id;
        $this->file_names = $file_names;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

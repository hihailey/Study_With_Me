<?php

namespace App\Events;


use App\Models\Video;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ViewStream implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $video;


    public function __construct($video)
    {
        $this->video = $video;
    }


    public function broadcastOn()
    {
        $i = $this->video->user_id;
        return new PresenceChannel('video-chat' . $i);
    }
}

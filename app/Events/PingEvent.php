<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $data;

    // /**
    //  * Create a new event instance.
    //  */
    // public function __construct(string $data)
    // {
    //     $this->data = $data;
    // }

    # You can use the snippet code above, but I prefer this new feature in php8
    public function __construct(public string $data)
    {
        //
    }

    public function broadcastAs()
    {
        return 'ping-alias';
    }

    public function broadcastWith()
    {
        return [
            'id' => 123,
            'message' => 'Hello World Ping Pong',
            'data-from-constructor'  => $this->data
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('ping-channel'),
        ];
    }
}

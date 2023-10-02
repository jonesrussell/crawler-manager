<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrawlerJobOutputEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $output;

    /**
     * Create a new event instance.
     */
    public function __construct($output)
    {
        logger('CrawlerJobOutputEvent event');
        logger('Output received:');
        logger($output);
        $this->output = $output;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channel = new PrivateChannel('crawler-job-output');

        logger('Broadcasting on channel: ' . $channel->name);

        return [$channel];
    }
}

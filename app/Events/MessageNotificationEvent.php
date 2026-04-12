<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $receiver_id;
    public $conversation_id;

    public function __construct(User $sender, $receiver_id, $conversation_id)
    {
        $this->sender = $sender;
        $this->receiver_id = $receiver_id;
        $this->conversation_id = $conversation_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->receiver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'message.notification';
    }
}

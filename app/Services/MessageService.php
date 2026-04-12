<?php

namespace App\Services;

use App\Models\Message;
use App\Models\User;
use App\Notifications\PrivateMessageNotification;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Events\MessageNotificationEvent;

class MessageService
{
    public function sendMessage(User $sender, array $data)
    {
        $message = $sender->messages()->create([
            'message' => $data['message'] ?? $data['content'],
            'conversation_id' => $data['conversation_id'],
        ]);

        // Dispatch message event
        event(new MessageSent($message, $data['conversation_id']));

        // Handle notifications if a receiver is implied by the conversation
        $otherParticipants = $message->conversation->users->where('id', '!=', $sender->id);
        foreach ($otherParticipants as $receiver) {
            // $receiver->notify(new PrivateMessageNotification($message->message, $sender));
            event(new MessageNotificationEvent($sender, $receiver->id, $data['conversation_id']));
        }

        return $message;
    }

    public function updateMessage(User $user, Message $message, string $content)
    {
        if ($user->id !== $message->sender_id) {
            return false;
        }

        $message->update([
            'message' => $content,
            'is_edited' => true,
        ]);

        // Dispatch update event
        event(new MessageUpdated($message));

        return $message;
    }
}

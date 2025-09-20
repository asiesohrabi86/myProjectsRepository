<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentToAdmin implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $formattedMessage;

    public function __construct(ChatMessage $message)
    {
        // اگر کاربری برای پیام وجود نداشت، رویداد را ارسال نکن یا یک حالت پیش‌فرض در نظر بگیر
        if (!$message->user) {
            $this->formattedMessage = []; // ارسال یک آبجکت خالی
            return;
        }

        $this->formattedMessage = [
            'id' => $message->id,
            'text' => $message->message,
            'is_sender' => false,
            'user' => [
                'id' => $message->user->id, // <-- اطمینان از وجود ID
                'name' => $message->user->name,
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) . '&background=random&color=fff'
            ]
        ];
    }

    public function broadcastOn(): array
    {
        // اگر پیام فرمت شده خالی بود، رویداد را پخش نکن
        if (empty($this->formattedMessage)) {
            return [];
        }
        
        return [
            new PrivateChannel('admin-chat'),
        ];
    }
}
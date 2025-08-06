<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\MessageSentToAdmin;

class ChatController extends Controller
{
    /**
     * واکشی پیام‌های یک مکالمه خاص
     */
    public function fetchMessages(Request $request, User $user)
    {
        // اطمینان از اینکه کاربر فعلی فقط به پیام‌های خودش دسترسی دارد
        if ($request->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // پیدا کردن پیام‌هایی که فرستنده یا گیرنده آن‌ها کاربر فعلی است
        $messages = ChatMessage::query()
            // **اصلاحیه: فقط پیام‌هایی که کاربر معتبر دارند را واکشی کن**
            ->whereHas('user') 
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('recipient_id', $user->id);
            })
            ->with('user:id,name') // فقط ستون‌های id و name را از رابطه user بگیر (بهینه‌تر)
            ->latest()
            ->limit(30)
            ->get()
            ->reverse()
            ->values();

        // فرمت کردن داده برای فرانت‌اند
        return response()->json($messages->map(function (ChatMessage $message) use ($user) {
            return [
                'id' => $message->id,
                'text' => $message->message,
                'is_sender' => $message->user_id === $user->id,
                'user' => [
                    'id' => $message->user->id,
                    'name' => $message->user->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($message->user->name) . '&background=random&color=fff'
                ]
            ];
        }));
    }

    /**
     * ارسال پیام جدید از طرف کاربر
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate(['message' => 'required|string|max:1000']);
        
        $user = $request->user();
        $admins = User::where('is_admin', true)->get();

        if ($admins->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No admin found'], 404);
        }

        $messageText = $validated['message'];
        $sentMessage = null;

        // **به ازای هر ادمین، یک پیام جداگانه ایجاد می‌کنیم**
        foreach($admins as $admin) {
            $message = ChatMessage::create([
                'user_id' => $user->id,
                'message' => $messageText,
                'recipient_id' => $admin->id, // گیرنده، هر ادمین است
            ]);
            if (!$sentMessage) $sentMessage = $message;
        }
        
        // رویداد را فقط یک بار و برای اطلاع‌رسانی کلی پخش می‌کنیم
        if ($sentMessage) {
            broadcast(new MessageSentToAdmin($sentMessage));
        }

        return response()->json(['status' => 'success', 'message' => $message], 201);
    }
}
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'recipient_id' => 'required|integer|exists:users,id',
        ]);
        
        $admin = auth()->user();

        $message = ChatMessage::create([
            'user_id' => $admin->id,
            'message' => $validatedData['message'],
            'recipient_id' => $validatedData['recipient_id'],
        ]);
        
        $message->load('user'); // بارگذاری اطلاعات فرستنده (ادمین)

        // پخش رویداد برای کاربر. toOthers() تضمین می‌کند که به تب فعلی ادمین ارسال نشود.
        broadcast(new MessageSent($message))->toOthers();

        // **: بازگرداندن پاسخ JSON به جای ریدایرکت**
        // ما پیام جدید را برمی‌گردانیم تا فرانت‌اند بتواند ID واقعی آن را داشته باشد.
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'text' => $message->message,
                'is_sender' => true,
                'user' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=random&color=fff'
                ]
            ]
        ], 201); // 201 Created
    }

    public function markAsRead(User $user)
    {
        // تمام پیام‌هایی که این کاربر برای ادمین فرستاده و خوانده نشده‌اند را آپدیت کن
        ChatMessage::query()
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return response()->noContent(); // یک پاسخ موفقیت‌آمیز بدون محتوا
    }
}
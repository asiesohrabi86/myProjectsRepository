<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:1000',
            'recipient_id' => 'required|integer|exists:users,id',
        ]);
        
        $message = ChatMessage::create([
            'user_id' => auth()->id(),
            'message' => $validatedData['message'],
            'recipient_id' => $validatedData['recipient_id'],
        ]);

        $message->load('user');
        
        // **برای اطمینان، رویداد را به صورت آنی پخش می‌کنیم**
        broadcast(new MessageSent($message))->toOthers();

        return redirect()->back();
    }
}
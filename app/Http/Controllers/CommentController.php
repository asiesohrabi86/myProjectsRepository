<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
{
    public function sendComment(Request $request)
    {
        $request->validate([
            'commentable_id'=>'required',
            'commentable_type'=>'required',
            'parent_id'=>'required',
            'text'=>'required',
        ]);

        // $request->user()->comments()->create($request->all());
        $request['user_id']=Auth::user()->id;
        $comment = Comment::create($request->all());
        // برای ارسال نوتیف به همه ادمین ها
        $admins = User::where('is_admin', true)->get();
        $notificationData = [
            'text' => "یک نظر جدید برای محصول . {$comment->commentable->title} . ثبت شد",
            'icon' => 'fa-user-plus text-info',
            'url' => route('users.show', $user->id) // یک لینک به پروفایل کاربر
        ];
        Notification::send($admins, new GeneralNotification($notificationData));
        alert()->success('نظر شما با موفقیت ثبت شد، بعد از تأیید نمایش داده خواهد شد');
        // لاگ کردن فعالیت
        return back();
    }
}

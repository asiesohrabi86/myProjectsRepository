<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
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
        try {
            $admins = User::where('is_admin', true)->get();
            if ($admins->isNotEmpty()) {
                $productTitle = $comment->commentable ? $comment->commentable->title : 'یک محصول';
                
                $notificationData = [
                    'text' => "نظر جدیدی از طرف \"{$request->user()->name}\" برای محصول \"{$productTitle}\" ثبت شد.",
                    'icon' => 'fa-comment text-warning',
                    'url'  => route('unapproved.get') 
                ];

                // **استفاده از حلقه برای جلوگیری از خطای Duplicate ID**
                foreach ($admins as $admin) {
                    $admin->notify(new GeneralNotification($notificationData));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send new comment notification: ' . $e->getMessage());
        }
        alert()->success('نظر شما با موفقیت ثبت شد، بعد از تأیید نمایش داده خواهد شد');
        // لاگ کردن فعالیت
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Comment::create($request->all());
        alert()->success('نظر شما با موفقیت ثبت شد، بعد از تأیید نمایش داده خواهد شد');
        return back();
    }
}

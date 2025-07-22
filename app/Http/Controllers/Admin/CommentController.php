<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:comments,user')->only('index');
        $this->middleware('can:comment-destroy,user')->only('destroy');
        $this->middleware('can:comment-unapproved,user')->only(['unapprovedGet','unapprovedPost']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with(['commentable', 'parent'])->get();
        return view('dashboard.comments.all',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        // // dd($comment);
        // $comment->update([
        //     'approved'=>1
        // ]);
        // // $comment->approved = 1;
        // // $comment->save();
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }

    public function unapprovedGet()
    {
       $comments = Comment::with(['commentable', 'parent'])->where('approved',0)->get();
        return view('dashboard.comments.unapproved',compact('comments'));
    }

    public function unapprovedPost(Comment $comment)
    {
        $comment->approved = 1;
        $comment->save();
        // $comment->update([
        //     'approved'=> '1',
        // ]);
        return back();
    }
}

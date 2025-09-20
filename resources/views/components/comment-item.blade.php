<li style="margin-right: {{ $level * 30 }}px;">
    <div class="comment-body">
        <div class="comment-author">
            <img alt="" src="/assets/img/default-avatar.png" class="avatar">
            <cite class="fn">{{ $comment->user->name }}</cite>
            <span class="says">گفت:</span>
            <!-- @if($comment->parent_id)
                <span class="badge badge-info ml-2">پاسخ به نظر</span>
            @endif -->
        </div>
        <div class="commentmetadata">{{ $comment->created_at }}</div>
        <p>{{ $comment->text }}</p>
        @if($comment->children->where('approved', 1)->count() == 0)
            <div class="reply">
                <a class="comment-reply-link" href="javascript:void(0);" onclick="document.getElementById('reply-form-{{$comment->id}}').style.display='block'">پاسخ به نظر</a>
            </div>
        @endif
        <!-- فرم پاسخ -->
        <form id="reply-form-{{$comment->id}}" action="{{route('send.comment')}}" class="comment mt-2" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="commentable_id" value="{{$product->id}}">
            <input type="hidden" name="commentable_type" value="{{get_class($product)}}">
            <input type="hidden" name="parent_id" value="{{$comment->id}}">
            <textarea class="form-control" placeholder="پاسخ خود را بنویسید..." rows="3" name="text"></textarea>
            <button class="btn btn-sm btn-primary mt-1" type="submit">ارسال پاسخ</button>
            <button type="button" class="btn btn-sm btn-secondary mt-1" onclick="document.getElementById('reply-form-{{$comment->id}}').style.display='none'">انصراف</button>
        </form>
    </div>
    @if($comment->children && $comment->children->count())
        <ul class="children">
            @foreach($comment->children->where('approved', 1)->all() as $child)
                @include('components.comment-item', ['comment' => $child, 'product' => $product, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li> 
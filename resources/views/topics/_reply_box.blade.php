@include('shared._error')

<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="post" id="reply">
        {{ csrf_field() }}
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">

        <div class="form-group">
            <textarea name="content" id="content" class="form-control" placeholder="分享你的见解~" rows="3"></textarea>
        </div>

        <div class="form-group text-right">
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-share"></i>
            回复
        </button>
        </div>
    </form>
</div>

<hr>
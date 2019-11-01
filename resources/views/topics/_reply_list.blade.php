<ul id="reply_list" class="list-unstyled">
    @foreach($replies as $reply)
        @include('topics._reply_item')

        @if(!$loop->last)
            <hr>
        @endif
    @endforeach
</ul>
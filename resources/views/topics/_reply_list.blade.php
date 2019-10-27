<ul class="list-unstyled">
    @foreach($replies as $reply)
        <li class="media" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
            <div class="media-left">
                <a href="{{ route('users.show', $reply->user) }}">
                    <img class="media-object img-thumbnail mr-3" src="{{ $reply->user->avatar }}"
                         alt="{{ $reply->user->name }}" title="{{ $reply->user->name }}"
                         style="width:48px;height:48px;">
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading mt-0 mb-1 text-secondary">
                    <a href="{{ route('users.show', $reply->user) }}"
                       title="{{ $reply->user->name }}">{{ $reply->user->name }}</a>
                    <span class="text-secondary"> • </span>
                    <span class="meta text-secondary"
                          title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>

                    @can('destroy', $reply)
                        <span class="meta float-right">
                        <form action="{{ route('replies.destroy', $reply) }}" method="post"
                              onsubmit="return confirm('确定要删除此评论？')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-default btn-xs pull-left text-secondary">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </span>
                    @endcan
                </div>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
            </div>
        </li>

        @if(!$loop->last)
            <hr>
        @endif
    @endforeach
</ul>
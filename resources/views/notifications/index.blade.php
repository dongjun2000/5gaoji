@extends('layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-body">
                <h3>
                    <i class="far fa-bell"></i> 我的通知
                </h3>

                @if ($notifications->count())
                    @foreach($notifications as $notification)
                        @include('notifications.types._' . snake_case(class_basename($notification->type)))
                    @endforeach

                    {{ $notifications->links() }}
                @else
                    <div class="empty-block">没有消息通知！</div>
                @endif
            </div>
        </div>
    </div>
@stop
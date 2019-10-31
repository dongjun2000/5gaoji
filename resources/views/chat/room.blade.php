@extends('layouts.app')

@section('title', '房间')

@section('content')
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>请友善聊天~~~</strong>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-transparent"><strong>房间</strong></div>
        <div class="card-body">
            <ul class="nav nav-pills">
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a href="{{ route('chat.room', $category->id) }}" class="nav-link {{ active_class(if_route_param('room', $category->id)) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <chat-room-component></chat-room-component>
@stop
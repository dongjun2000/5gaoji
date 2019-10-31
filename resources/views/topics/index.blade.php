@extends('layouts.app')

@section('title', isset($category) ? $category->name : '话题列表')

@section('content')
    <div class="row">
        <div class="col-md-9 topic-list">

            @if(isset($category))
                <div class="alert alert-info" role="alert">
                    {{ $category->name }} : {{ $category->description }}
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-transparent">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_query('order', '')) }}" href="{{ Request::url() }}">最后回复</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(if_query('order', 'recent')) }}"
                               href="{{ Request::url() }}?order=recent">最新发布</a>
                        </li>
                        @if(isset($category))
                            <li class="nav-item float-right">
                                <a class="nav-link" href="{{ route('chat.room', ['room' => $category->id]) }}">进入房间</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    {{--话题列表--}}
                    @include('topics._topic_list', ['topics' => $topics])
                    {{--分页--}}
                    <div class="mt-5">
                        {!! $topics->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mt-md-0 mt-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>
@stop
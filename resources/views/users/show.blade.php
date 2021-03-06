@extends('layouts.app')

@section('title', $user->name . '的个人主页')

@section('content')
    <div class="row">
        <div class="col-md-3 user-info">
            <div class="card">
                <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}" title="{{ $user->name }}">
                <div class="card-body">
                    <h1 class="card-title" style="font-size:22px">
                        {{ $user->name }}
                        <small class="text-primary"><i class="fa fa-mars"></i></small>
                    </h1>
                    <hr>
                    <h5 class="card-title">个人简介</h5>
                    <p>{{ $user->intro }}</p>
                    <hr>
                    <h5>注册于</h5>
                    {{ $user->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0 text-center">
                        最后活跃于 {{ $user->last_actived_at->diffForHumans() }}
                    </h5>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-transparent">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}"
                               href="{{ route('users.show', $user) }}">Ta 的话题</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}"
                               href="{{ route('users.show', [$user, 'tab' => 'replies']) }}">Ta 的回复</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @if(if_query('tab', 'replies'))
                        @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
                    @elseif(if_query('tab', null))
                        @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
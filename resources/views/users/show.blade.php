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
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0" >
                        注册于 {{ $user->created_at->diffForHumans() }}
                    </h5>
                </div>
            </div>

            <div class="card mt-3">

                <div class="card">
                    <div class="card-header bg-transparent">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Ta 的话题</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Ta 的回复</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
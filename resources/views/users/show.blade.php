@extends('layouts.app')

@section('title', $user->name . '的个人主页')

@section('content')
    <div class="row">
        <div class="col-md-3 user-info">
            <div class="card">
                <img class="card-img-top" src="https://www.mi360.cn/imgs/default/face.jpg" alt="{{ $user->name }}" title="{{ $user->name }}">
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
                <div class="card-body">
                    暂无数据 ~_~
                </div>
            </div>
        </div>
    </div>
@stop
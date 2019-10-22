@extends('layouts.app')

@section('title', $user->name . '的个人主页')

@section('content')
    <div class="row">
        <div class="col-md-3 user-info">
            <div class="card">
                <img class="card-img-top" src="https://www.mi360.cn/imgs/default/face.jpg" alt="{{ $user->name }}" title="{{ $user->name }}">
                <div class="card-body">
                    <h5>个人简介</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <hr>
                    <h5>注册于</h5>
                    <p>2年前</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px">
                        {{ $user->name }}
                        <small>{{ $user->email }}</small>
                    </h1>
                </div>
            </div>

            <hr>

            <div class="card">
                <div class="card-body">
                    暂无数据 ~_~
                </div>
            </div>
        </div>
    </div>
@stop
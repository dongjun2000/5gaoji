@extends('layouts.app')

@section('title', '编辑个人资料')

@section('content')
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4><i class="fa fa-user-edit"></i>编辑个人资料</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    @include('shared._error')

                    <div class="form-group">
                        <label for="name">昵称：</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $user->name) }}">
                        <small class="form-text text-muted"><i class="fa fa-info-circle"></i>姓名只能包含大小写字母、数字和下划线，不能包含中文
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="email">邮箱：</label>
                        <input type="text" class="form-control" id="email" name="email"
                               value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="form-group">
                        <label for="intro">个人简介：</label>
                        <textarea class="form-control" id="intro" name="intro"
                                  rows="3">{{ old('intro', $user->intro) }}</textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="avatar" class="avatar-label">用户头像</label>
                        <input type="file" id="avatar" name="avatar" class="form-control-file">

                        @if($user->avatar)
                            <br>
                            <img class="img-thumbnail" src="{{ $user->avatar }}" width="200">
                        @endif
                    </div>

                    <button class="btn btn-primary">保存</button>
                </form>
            </div>
        </div>
    </div>
@stop
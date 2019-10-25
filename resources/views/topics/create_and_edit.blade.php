@extends('layouts.app')

@section('title', '发帖')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
    <script src="{{ asset('js/module.js') }}"></script>
    <script src="{{ asset('js/hotkeys.js') }}"></script>
    <script src="{{ asset('js/uploader.js') }}"></script>
    <script src="{{ asset('js/simditor.js') }}"></script>

    <script>
        $(document).ready(function () {
            new Simditor({
                textarea: $('#editor'),
                upload: {
                    // 处理上传图片的 URL；
                    url: '{{ route('topics.upload_image') }}',
                    // 表单提交的参数，Laravel 的 POST 请求必须带防止 CSRF 跨站请求伪造的 _token 参数；
                    params: {
                        _token: $("meta[name='csrf-token']").attr('content')
                    },
                    // 服务器端获取图片的键值，我们设置为 upload_file;
                    fileKey: 'upload_file',
                    // 最多只能同时上传 3 张图片
                    connectionCount: 3,
                    // 上传过程中，用户关闭页面时的提醒
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                // 设定是否支持图片黏贴上传，这里我们使用 true 进行开启；
                pasteImage: true
            });
        });
    </script>
@stop

@section('content')
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-body">
                <h2 class="">
                    <i class="far fa-edit"></i>
                    @if($topic->id)
                        编辑话题
                    @else
                        新建话题
                    @endif
                </h2>
                <hr>
                <form action="{{ route('topics.store') }}" method="post">
                    {{ csrf_field() }}

                    @include('shared._error')

                    <div class="form-group">
                        <input type="text" name="title" value="{{ old('title', $topic->title) }}" class="form-control"
                               placeholder="请填写标题" required>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="category_id" required>
                            <option value="" hidden disabled selected>请选择分类</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea name="body" class="form-control" id="editor" rows="6" placeholder="请填写至少三个字符的内容"
                                  required>{{ old('body', $topic->body) }}</textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="far fa-save"></i>
                            保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
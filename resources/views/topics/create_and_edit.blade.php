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
            var editor = new Simditor({
                textarea: $('#editor')
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
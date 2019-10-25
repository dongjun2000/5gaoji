@extends('layouts.app')

@section('title', $topic->title)

@section('description', $topic->excerpt)

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        作者：{{ $topic->user->name }}
                    </div>
                    <hr>
                    <div class="media justify-content-center">
                        <a href="{{ route('users.show', $topic->user) }}">
                            <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px"
                                 height="300px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 mt-3 mt-md-0 topic-content">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $topic->title }}
                    </h1>

                    <div class="article-meta text-center text-secondary">
                        {{ $topic->created_at->diffForHumans() }}
                        ⋅
                        <i class="far fa-comment"></i>
                        {{ $topic->reply_count }}
                    </div>

                    <div class="topic-body mt-4 mb-4">
                        {!! $topic->body !!}
                    </div>

                    <div class="operate">
                        <hr>
                        <a href="{{ route('topics.edit', $topic) }}" class="btn btn-outline-secondary btn-sm" role="button">
                            <i class="far fa-edit"></i> 编辑
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm" role="button">
                            <i class="far fa-trash-alt"></i> 删除
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
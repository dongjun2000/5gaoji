@extends('layouts.app')

@section('title', $topic->title)

@section('content')
    {{ $topic->title }}
@stop
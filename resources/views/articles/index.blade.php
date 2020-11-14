@extends('layouts.app')

@section('title', isset($category) ? $category->name : '文章列表')

@section('content')

<div class="row mb-5">
  <div class="col-lg-9 col-md-9 article-list">
    {{-- @if (isset($category))
      <div class="alert alert-info" role="alert">
        {{ $category->name }} ：{{ $category->description }}
      </div>
    @endif --}}
    <div class="card ">

      <div class="navbar navbar-default bg-transparent" style="background-color: rgba(0, 0, 0, 0.03) !important;">
          <div class="container-fluid">
              <div class="navbar-header">
                @if(!isset($category))
                <h3>全部新闻</h3>
                @else
                <h3>{{ $category->name }}新闻</h3>
                @endif
              </div>
              <ul class="nav nav-pills navbar-right">
                <li class="nav-item"><a class="nav-link {{ active_class( ! if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=default">最后回复</a></li>
                <li class="nav-item"><a class="nav-link {{ active_class(if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=recent">最新发布</a></li>
              </ul>
          </div>
      </div>

      <div class="card-body">
        {{-- 话题列表 --}}
        @include('articles._article_list', ['articles' => $articles])
        {{-- 分页 --}}
        <div class="mt-5">
          {!! $articles->appends(Request::except('page'))->render() !!}
        </div>
      </div>
    </div>

  </div>

  <div class="col-lg-3 col-md-3 sidebar">
    @include('articles._sidebar')
  </div>
</div>

@endsection

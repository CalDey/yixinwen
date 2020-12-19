@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
    <img class="card-img-top" src="{{$user->avatar}}" alt="{{ $user->name }}">
      <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            @if($user->introduction)
            <p>{{$user->introduction}}</p>
            @else
            <p>这个人很懒...什么也没有留下</p>
            @endif
            <hr>

            <h5><strong>最后活跃</strong></h5>
            <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
            <hr>

            <a><strong class="stat">
              {{$user->articles()->count()}}
            </strong>
            投稿
            </a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a><strong class="stat">
              {{$user->articles()->where('status','1')->count()}}
            </strong>
            过审
            </a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a><strong class="stat">
              {{$user->articles()->where('is_recommend','1')->count()}}
            </strong>
            推荐
            </a>


      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    {{-- 用户发布的内容 --}}
    <div class="card ">
      <div class="card-body">
      @if(Auth::id() == $user->id)
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
              我的文章
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'audit_pass')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'audit_pass']) }}">
              审核通过
            </a>
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'audit_sec')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'audit_sec']) }}">
              二次审核
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
              我的回复
            </a>
          </li>
        </ul>
          @if (if_query('tab', 'audit_pass'))
            @include('users._articles_audit_pass',['articles'=>$user->articles()->where('status','1')->recent()->paginate(10)])
          @elseif (if_query('tab', 'audit_sec'))
            @include('users._articles_audit_sec',['articles'=>$user->articles()->where('status','-1')->recent()->paginate(10)])
          @elseif (if_query('tab', 'replies'))
            @include('users._replies',['replies'=>$user->replies()->with('article')->recent()->paginate(5)])
          @else
            @include('users._articles',['articles'=>$user->articles()->recent()->paginate(10)])
          @endif

        @else
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
                Ta的文章
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
                Ta的回复
              </a>
            </li>
          </ul>
        @if (if_query('tab', 'replies'))
          @include('users._replies',['replies'=>$user->replies()->with('article')->recent()->paginate(5)])
        @else
          @include('users._articles',['articles'=>$user->articles()->where('status','1')->recent()->paginate(10)])
        @endif

      @endif

      </div>
    </div>

  </div>
</div>
@stop

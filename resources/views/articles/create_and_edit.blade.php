@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h1>
          Article /
          @if($article->id)
            Edit #{{ $article->id }}
          @else
            Create
          @endif
        </h1>
      </div>

      <div class="card-body">
        @if($article->id)
          <form action="{{ route('articles.update', $article->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('articles.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('common.error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $article->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $article->body ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $article->user_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="category_id-field">Category_id</label>
                    <input class="form-control" type="text" name="category_id" id="category_id-field" value="{{ old('category_id', $article->category_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="reply_count-field">Reply_count</label>
                    <input class="form-control" type="text" name="reply_count" id="reply_count-field" value="{{ old('reply_count', $article->reply_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="view_count-field">View_count</label>
                    <input class="form-control" type="text" name="view_count" id="view_count-field" value="{{ old('view_count', $article->view_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="last_reply_user_id-field">Last_reply_user_id</label>
                    <input class="form-control" type="text" name="last_reply_user_id" id="last_reply_user_id-field" value="{{ old('last_reply_user_id', $article->last_reply_user_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="order-field">Order</label>
                    <input class="form-control" type="text" name="order" id="order-field" value="{{ old('order', $article->order ) }}" />
                </div> 
                <div class="form-group">
                	<label for="excerpt-field">Excerpt</label>
                	<textarea name="excerpt" id="excerpt-field" class="form-control" rows="3">{{ old('excerpt', $article->excerpt ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="slug-field">Slug</label>
                	<input class="form-control" type="text" name="slug" id="slug-field" value="{{ old('slug', $article->slug ) }}" />
                </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('articles.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

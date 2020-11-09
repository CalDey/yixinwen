@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
      <div class="card-header">
        <h1>Article / Show #{{ $article->id }}</h1>
      </div>

      <div class="card-body">
        <div class="card-block bg-light">
          <div class="row">
            <div class="col-md-6">
              <a class="btn btn-link" href="{{ route('articles.index') }}"><- Back</a>
            </div>
            <div class="col-md-6">
              <a class="btn btn-sm btn-warning float-right mt-1" href="{{ route('articles.edit', $article->id) }}">
                Edit
              </a>
            </div>
          </div>
        </div>
        <br>

        <label>Title</label>
<p>
	{{ $article->title }}
</p> <label>Body</label>
<p>
	{{ $article->body }}
</p> <label>User_id</label>
<p>
	{{ $article->user_id }}
</p> <label>Category_id</label>
<p>
	{{ $article->category_id }}
</p> <label>Reply_count</label>
<p>
	{{ $article->reply_count }}
</p> <label>View_count</label>
<p>
	{{ $article->view_count }}
</p> <label>Last_reply_user_id</label>
<p>
	{{ $article->last_reply_user_id }}
</p> <label>Order</label>
<p>
	{{ $article->order }}
</p> <label>Excerpt</label>
<p>
	{{ $article->excerpt }}
</p> <label>Slug</label>
<p>
	{{ $article->slug }}
</p>
      </div>
    </div>
  </div>
</div>

@endsection

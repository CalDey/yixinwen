<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Reply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\ReplyRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class RepliesController extends Controller
{
    public function index($articleId, Reply $reply)
    {
        $replies = QueryBuilder::for(Reply::class)
        ->allowedIncludes('user', 'article')
        ->where('article_id', $articleId)->paginate();

        return ReplyResource::collection($replies);
    }

    public function userIndex($userId, Reply $reply)
    {
        $replies = QueryBuilder::for(Reply::class)
        ->allowedIncludes('user', 'article', 'article.user')
        ->where('user_id', $userId)->paginate();

        return ReplyResource::collection($replies);
    }

    public function store(ReplyRequest $request, Article $article, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->article()->associate($article);
        $reply->user()->associate($request->user());
        $reply->save();

        return new ReplyResource($reply);
    }

    public function destroy(Article $article, Reply $reply)
    {
        if($reply->article_id != $article->id){
            abort(404);
        }

        $this->authorize('destroy', $reply);
        $reply->delete();

        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Reply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\ReplyRequest;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Article $article, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->article()->associate($article);
        $reply->user()->associate($request->user());
        $reply->save();

        return new ReplyResource($reply);
    }
}

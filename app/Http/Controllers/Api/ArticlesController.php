<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Http\Resources\ArticleResource;
use App\Http\Requests\Api\ArticleRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ArticlesController extends Controller
{
    public function index(Request $request, Article $article)
    {
        $topics = QueryBuilder::for(Article::class)
            ->allowedIncludes('user', 'category')
            ->allowedFilters([
                'title',
                AllowedFilter::exact('category_id'),
                AllowedFilter::scope('withOrder')->default('recentReplied'),
            ])->where('status', 1)->paginate();

        return ArticleResource::collection($topics);
    }

    public function userIndex(Request $request, User $user)
    {
        $query = $user->articles()->getquery();

        $articles = QueryBuilder::for($query)
                    ->allowedIncludes('user', 'category')
                    ->allowedFilters([
                        'title',
                        AllowedFilter::exact('category_id'),
                        AllowedFilter::scope('withOrder')->default('recentReplied'),
                    ])->where('status', 1)->paginate();

        return ArticleResource::collection($articles);
    }

    public function show($articleId)
    {
        $article = QueryBuilder::for(Article::class)
                ->allowedIncludes('user','category')
                ->findOrFail($articleId);

        return new ArticleResource($article);
    }

    public function store(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();

        return new ArticleResource($article);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($request->all());
        return new ArticleResource($article);
    }

    public function destroy(Article $article)
    {
        $this->authorize('destroy', $article);

        $article->delete();

        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$articles = Article::paginate();
		return view('articles.index', compact('articles'));
	}

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

	public function create(Article $article)
	{
		return view('articles.create_and_edit', compact('article'));
	}

	public function store(ArticleRequest $request)
	{
		$article = Article::create($request->all());
		return redirect()->route('articles.show', $article->id)->with('message', 'Created successfully.');
	}

	public function edit(Article $article)
	{
        $this->authorize('update', $article);
		return view('articles.create_and_edit', compact('article'));
	}

	public function update(ArticleRequest $request, Article $article)
	{
		$this->authorize('update', $article);
		$article->update($request->all());

		return redirect()->route('articles.show', $article->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Article $article)
	{
		$this->authorize('destroy', $article);
		$article->delete();

		return redirect()->route('articles.index')->with('message', 'Deleted successfully.');
	}
}
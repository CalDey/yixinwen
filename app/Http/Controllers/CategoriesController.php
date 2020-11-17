<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class CategoriesController extends Controller
{
    public function show(Category $category,Request $request, Article $article, User $user)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $articles = $article->where('status', 1)
                            ->withOrder($request->order)
                            ->where('category_id', $category->id)
                            ->with('user','category') // 预加载防止N+1
                            ->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();

        // 传参变量话题和分类到模板中
        return view('articles.index', compact('articles', 'category','active_users'));
    }
}

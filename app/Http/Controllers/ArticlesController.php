<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Category;
use Auth;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show','recommend']]);
    }

	public function index(Request $request, Article $article, User $user)
	{
        $articles = $article->where('status', 1)
                            ->withOrder($request->order)
                            ->with('user','category') // 预加载防止N+1
                            ->paginate(20);

        $active_users = $user->getActiveUsers();
        // dd($active_users);

		return view('articles.index', compact('articles', 'active_users'));
	}

    public function show(Request $request, Article $article)
    {

        // 纠正url
        if (!empty($article->slug) && $article->slug != $request->slug) {
            return redirect($article->link(), 301);
        }

        // $article->increment('view_count', 1, ['updated_at' => $article->updated_at]);
        $article->visits()->increment();

        return view('articles.show', compact('article'));
    }

	public function create(Article $article)
	{
        $categories = Category::all();
		return view('articles.create_and_edit', compact('article','categories'));
	}

	public function store(ArticleRequest $request, Article $article)
	{
        $article->fill($request->all());
        $article->user_id = Auth::id();
        $article->save();
		return redirect()->to($article->link())->with('success', '文章创建成功');
	}

	public function edit(Article $article)
	{
        $this->authorize('update', $article);
        $categories = Category::all();
		return view('articles.create_and_edit', compact('article','categories'));
	}

	public function update(ArticleRequest $request, Article $article)
	{
		$this->authorize('update', $article);
        $article->update($request->all());
        $article->status = '2';
        $article->save();

		return redirect()->to($article->link())->with('message', 'Updated successfully.');
	}

	public function destroy(Article $article)
	{
		$this->authorize('destroy', $article);
		$article->delete();

		return redirect()->route('articles.index')->with('success', '成功删除！');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认为失败
        $data = [
            'success' => false,
            'msg' => '上传失败',
            'file_path' => ''
        ];
        // 判断是否有上传文件，赋值给$file
        if($file = $request->upload_file){
              // 保存图片到本地
              $result = $uploader->save($file, 'articles', \Auth::id(), 1024);
              // 图片保存成功的话
              if ($result) {
                  $data['file_path'] = $result['path'];
                  $data['msg']       = "上传成功!";
                  $data['success']   = true;
              }
        }
        return $data;
    }

    public function recommend(Request $request, Article $article, User $user)
	{
        $articles = $article->where('is_recommend', 1)
                            ->Recent($request)
                            ->with('user','category') //预加载防止N+1
                            ->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();

		return view('articles.recommend', compact('articles','active_users'));
    }

}

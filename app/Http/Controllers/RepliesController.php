<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(ReplyRequest $request, Reply $reply)
	{
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->article_id = $request->article_id;
        $reply->save();

		return redirect()->to($reply->article->link())->with('success', '评论发表成功！');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->route('replies.index')->with('success', '评论删除成功！');
	}
}

<?php

namespace App\Observers;

use App\Models\Article;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ArticleObserver
{
    public function saving(Article $article)
    {
        // XSS 过滤
        $article->body = clean($article->body, 'user_aticle_body');

        // 生成话题摘录
        $article->excerpt = make_excerpt($article->body);

    }

    public function saved(Article $article)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( !$article->slug || $article->isDirty('title')) {

            // $article->slug = app(SlugTranslateHandler::class)->translate($article->title);

            // 推送任务到队列
            dispatch(new TranslateSlug($article));
        }

    }

    public function deleted(Article $article)
    {
        \DB::table('replies')->where('article_id', $article->id)->delete();
    }


}

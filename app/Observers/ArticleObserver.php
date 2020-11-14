<?php

namespace App\Observers;

use App\Models\Article;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ArticleObserver
{
    public function saving(Article $article)
    {
        $article->body = clean($article->body, 'user_aticle_body');

        $article->excerpt = make_excerpt($article->body);
    }

}

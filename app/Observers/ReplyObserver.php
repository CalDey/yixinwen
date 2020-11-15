<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->article->reply_count = $reply->article->replies->count();
        $reply->article->save();
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_article_body');
    }

}

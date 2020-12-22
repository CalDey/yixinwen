<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => (int) $this->user_id,
            'article_id' => (int) $this->article_id,
            'content' => $this->content,
            'create_at' => (string) $this->created_at,
            'update_at' => (string) $this->updated_at,
        ];
    }
}

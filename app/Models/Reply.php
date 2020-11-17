<?php

namespace App\Models;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Reply extends Model
{

    use DefaultDatetimeFormat;

    protected $fillable = ['content'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

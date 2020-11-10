<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    protected $fillable = ['title', 'body', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        //按照创建时间排序
        return $query-> orderBy('created_at','desc');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("avaiable",function(Builder $builder){
            $builder->whereIn('status',[0,1]);
        });
    }

}

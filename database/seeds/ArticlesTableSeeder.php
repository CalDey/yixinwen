<?php

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $articles = factory(Article::class)->times(50)->make()->each(function ($article, $index) {
            if ($index == 0) {
                // $article->field = 'value';
            }
        });

        Article::insert($articles->toArray());
    }

}


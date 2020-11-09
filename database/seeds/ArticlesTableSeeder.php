<?php

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Article::class)->times(100)->create();
    }
}

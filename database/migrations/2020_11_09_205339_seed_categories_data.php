<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    public function up()
    {
        $categories = [
            [
                'name'        => '热点',
            ],
            [
                'name'        => '财经',
            ],
            [
                'name'        => '娱乐',
            ],
            [
                'name'        => '科技',
            ],
            [
                'name'        => '旅游',
            ],
            [
                'name'        => '体育',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    public function down()
    {
        DB::table('categories')->truncate();
    }
}

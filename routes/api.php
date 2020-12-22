<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {

        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                // 图片验证码
                Route::post('captchas', 'CaptchasController@store')
                    ->name('captchas.store');
                // 短信验证码
                Route::post('verificationCodes', 'VerificationCodesController@store')
                    ->name('verificationCodes.store');
                // 用户注册
                Route::post('users', 'UsersController@store')
                    ->name('users.store');
                // 第三方登录（微信）
                Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
                ->where('social_type', 'wechat')
                ->name('socials.authorizations.store');
            });
                // 用户登录
                Route::post('authorizations', 'AuthorizationsController@store')
                      ->name('authorizations.store');

                // 刷新token
                Route::put('authorizations/current', 'AuthorizationsController@update')
                    ->name('authorizations.update');
                // 删除token
                Route::delete('authorizations/current', 'AuthorizationsController@destroy')
                    ->name('authorizations.destroy');

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {
                // 游客可以访问的接口

                // 某个用户的详情
                Route::get('users/{user}', 'UsersController@show')
                        ->name('users.show');
                // 分类列表
                Route::get('categories', 'CategoriesController@index')
                        ->name('categories.index');
                // 文章列表
                Route::resource('articles', 'ArticlesController')
                        ->only(['index','show']);
                // 评论列表
                Route::get('articles/{article}/replies','RepliesController@index')
                        ->name('articles.replies.index');
                // 某个用户的评论列表
                Route::get('users/{user}/replies', 'RepliesController@userIndex')
                        ->name('users.replies.index');
                // 某个用户发表的文章
                Route::get('users/{user}/articles', 'ArticlesController@userIndex')
                        ->name('users.articles.index');

                // 登录后可以访问的接口
                Route::middleware('auth:api')->group(function() {
                    // 当前登录用户信息
                    Route::get('user', 'UsersController@me')
                        ->name('user.show');
                    // 编辑登录用户信息
                    Route::patch('user', 'UsersController@update')
                        ->name('user.update');
                    // 上传照片
                    Route::post('images', 'ImagesController@store')
                        ->name('image.store');
                    // 发布文章
                    Route::resource('articles', 'ArticlesController')->only(['store','update','destroy']);
                    // 发布评论
                    Route::post('articles/{article}/replies', 'RepliesController@store')
                        ->name('articles.replies.store');
                    // 删除评论
                    Route::delete('articles/{article}/replies/{reply}', 'RepliesController@destroy')
                        ->name('articles.replies.destroy');

                });
            });
    });



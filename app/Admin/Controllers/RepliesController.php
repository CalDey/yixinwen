<?php

namespace App\Admin\Controllers;

use App\Models\Reply;
use App\Models\User;
use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RepliesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reply());

        $grid->id('ID');
        $grid->article_id('文章标题')->display(function($articleId) {
            return Article::find($articleId)->title;
        });
        $grid->user_id('用户ID')->display(function($userId) {
            return User::find($userId)->name;
        });
        $grid->content('评论内容')->limit(30);
        $grid->created_at('发布时间');
        // $grid->updated_at('修改时间');

        $grid->setActionClass(Actions::class);

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {

            // 去掉编辑
            $actions->disableEdit();
            // 去掉查看
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    // protected function detail($id)
    // {
    //     $show = new Show(Reply::findOrFail($id));

    //     $show->field('id', __('Id'));
    //     $show->field('article_id', __('Article id'));
    //     $show->field('user_id', __('User id'));
    //     $show->field('content', __('Content'));
    //     $show->field('created_at', __('Created at'));
    //     $show->field('updated_at', __('Updated at'));

    //     return $show;
    // }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    // protected function form()
    // {
    //     $form = new Form(new Reply());

    //     $form->number('article_id', __('Article id'));
    //     $form->number('user_id', __('User id'));
    //     $form->textarea('content', __('Content'));

    //     return $form;
    // }
}

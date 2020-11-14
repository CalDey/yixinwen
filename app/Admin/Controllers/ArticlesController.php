<?php

namespace App\Admin\Controllers;

use App\Models\Article;
// use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Grid\Displayers\Actions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\User;
use App\Models\Category;
use DB;
use Admin;

class ArticlesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->selector(function (Grid\Tools\Selector $selector) {
            $selector->select('status', '审核状态', [
                0 => '未审核',
                1 => '通过',
                2 => '复审',

            ]);
            $selector->select('category_id', '文章分类', [
                1 => '热点',
                2 => '财经',
                3 => '娱乐',
                4 => '科技',
                5 => '旅游',
                6 => '体育',
            ]);
            if (Admin::user()->can('chief-editor')) {
                $selector->select('is_recommend', '首页推荐', [
                    -1 => '申请',
                    1 => '推荐',
                ]);
            }

        });


        // 审核状态过滤
        // $grid->model()->whereIn('status', [0]);

        $grid->id('ID')->sortable();
        $grid->title('文章标题');
        // $grid->column('body', __('Body'));
        $grid->user_id('作者')->display(function($userId) {
            return User::find($userId)->name;
        });
        $grid->category_id('分类')->display(function($CategoryId) {
            return Category::find($CategoryId)->name;
        });
        // $grid->column('order', __('Order'));
        $grid->status('审核状态')->using(['0' => '未审核', '1' => '通过', '2'=>'复审']);
        $grid->created_at('发布时间')->sortable();
        $grid->updated_at('修改时间')->sortable();

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        // 最原始的`按钮图标`形式
        $grid->setActionClass(Actions::class);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {

        $show = new Show(Article::findOrFail($id));
        $show->field('id', __('ID'));
        $show->field('title', __('Title'));
        $show->field('body', __('Body'));
        // $show->field('user_id', __('User id'));
        // $show->field('category_id', __('Category id'));
        // $show->field('order', __('Order'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->text('title', __('标题'));
        // $form->textarea('body', __('内容'));
        $form->simditor('body', __('内容'));
        // $form->number('user_id', __('User id'));
        // $form->number('category_id', __('Category id'));
        // $form->number('order', __('Order'));
        // $form->switch('status', __('Status'));
        // $form->textarea('suggestion', __('修改意见'));
        // $states = [
        //     'on'  => ['value' => 1, 'text' => '通过', 'color' => 'success'],
        //     'off' => ['value' => -1, 'text' => '不通过', 'color' => 'danger'],
        // ];

        // $form->switch('status', __('审核'))->states($states);

        //获取当前模型ID(最好封装成函数)
        $arr = request()->route()->parameters();
        $id = (isset($arr['article'])?$arr['article']:0);
        if($id){
        $info = Article::where('id',$id)->findOrFail($id);
        $audit_status = $info['status'];
        $recommend = $info['is_recommend'];
        }

        // 审核是否通过
        if ($audit_status != 2) {

            $status = [
                1 => '通过',
                -1 => '不通过',
            ];

            // 第一次审核->通过审核是否推荐
            $form->select('status', '审核状态')->options($status)->when(1, function(Form $form) {

                // 编辑权限 推荐申请
                if (Admin::user()->can('editor')) {

                    $arr = request()->route()->parameters();
                    $id = (isset($arr['article'])?$arr['article']:0);
                    if($id){
                    $info = Article::where('id',$id)->findOrFail($id);
                    $recommend = $info['is_recommend'];
                    }

                    if ($recommend != 1) {
                        $form->radioButton('is_recommend', '是否推荐')->options(['-1' => '推荐', '0'=> '不推荐'])->default('0');
                    }

                }

                // 高级编辑权限
                if (Admin::user()->can('chief-editor')) {
                    $form-> switch('is_recommend', '推荐');
                }


            // 未审核通过,提交修改意见
            })->when(-1, function (Form $form) {

                $form->textarea('suggestion', __('修改意见'));

            });

        }

        else {

            // 第二次审核->复审是否通过->是否推荐
            $status = [
                1 => '通过',
                -2 => '不通过',
            ];

            // 复审通过
            $form->select('status', '二次审核')->options($status)->when(1, function(Form $form) {

                // 编辑权限 推荐申请
                if (Admin::user()->can('editor')) {
                    $form->radioButton('is_recommend', '是否推荐')->options(['-1' => '推荐', '0'=> '不推荐'])->default('0');
                }

                // 高级编辑权限
                if (Admin::user()->can('chief-editor')) {
                    $form-> switch('is_recommend', '推荐');
                }

            });

        }

        $form->tools(function (Form\Tools $tools) {

            // 去掉`查看`按钮
            $tools->disableView();

        });

        $form->footer(function ($footer) {

            // 去掉`查看`checkbox
            $footer->disableViewCheck();

            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();

            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();

        });

        return $form;
    }
}

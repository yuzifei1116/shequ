<?php

namespace App\Admin\Controllers;

use App\ActSpeaks;
use App\User;
use App\UserAct;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Post\GoUsers;

class ActSpeakController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActSpeaks());

        $grid->model()->orderBy('is_show', 'asc');

        $grid->column('id', __('索引'));
        $grid->column('users.nickname', __('评论者'));
        $grid->column('user_reply.nickname', __('被评论者'));
        $grid->column('content', __('评论内容'));
        $grid->column('is_show', __('审核'))->switch([
            'on'=>['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger']
        ]);
        $grid->column('created_at', __('评论时间'));

        $grid->column('回复')->action(GoUsers::class);//添加回复按钮

        $grid->disableCreateButton();

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
        $show = new Show(ActSpeaks::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('user_id', __('评论者'));
        $show->field('reply_id', __('被评论者'));
        $show->field('content', __('评论内容'));
        $show->field('is_show', __('审核'));
        $show->field('created_at', __('评论时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ActSpeaks());

        $form->number('userAct_id', __('UserAct id'));
        $form->number('user_id', __('User id'));
        $form->number('reply_id', __('Reply id'));
        $form->number('comment_id', __('Comment id'));
        $form->text('content', __('Content'));
        $form->switch('is_show', __('Is show'))->states([
            'on'=>['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger']
        ]);

        return $form;
    }
}

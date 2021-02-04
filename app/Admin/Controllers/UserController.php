<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('索引'));
        $grid->column('avatar', __('头像'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('nickname', __('昵称'));
        $grid->column('sex', __('性别'))->using(['0'=>'未知','1'=>'男','2'=>'女']);
        $grid->column('tel', __('手机号'));
        $grid->column('status', __('状态'))->switch([
            'on'=>['value' => 1, 'text' => '正常', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger']
        ]);
        $grid->column('created_at', __('注册时间'));

        $grid->disableActions();

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('openid', __('Openid'));
        $show->field('session_key', __('Session key'));
        $show->field('avatar', __('Avatar'));
        $show->field('nickname', __('Nickname'));
        $show->field('sex', __('Sex'));
        $show->field('tel', __('Tel'));
        $show->field('status', __('Status'));
        $show->field('token', __('Token'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('openid', __('Openid'));
        $form->text('session_key', __('Session key'));
        $form->image('avatar', __('Avatar'));
        $form->text('nickname', __('Nickname'));
        $form->switch('sex', __('Sex'))->default(1);
        $form->text('tel', __('Tel'));
        $form->switch('status', __('Status'))->states([
            'on'=>['value' => 1, 'text' => '正常', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'danger']
        ]);
        $form->text('token', __('Token'));

        return $form;
    }
}

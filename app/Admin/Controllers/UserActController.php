<?php

namespace App\Admin\Controllers;

use App\UserAct;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserActController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '动态管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserAct());

        $grid->column('id', __('索引'));
        $grid->column('title', __('文字'));
        $grid->column('img', __('图片'));
        $grid->column('user_id', __('用户'));
        $grid->column('is_show', __('是否显示'))->switch([
            'on'=>['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger']
        ]);
        $grid->column('created_at', __('发布时间'));

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
        
            // 去掉编辑
            $actions->disableEdit();

        });

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
        $show = new Show(UserAct::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('title', __('文字'));
        $show->field('img', __('图片'));
        $show->field('user_id', __('用户'));
        $show->field('is_show', __('是否显示'));
        $show->field('created_at', __('发布时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserAct());

        $form->text('title', __('Title'));
        $form->image('img', __('Img'));
        $form->number('user_id', __('User id'));
        $form->switch('is_show', __('Is show'))->states([
            'on'=>['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger']
        ]);

        return $form;
    }
}

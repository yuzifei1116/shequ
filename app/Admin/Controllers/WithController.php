<?php

namespace App\Admin\Controllers;

use App\With;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WithController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户点赞';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new With());

        $grid->column('id', __('索引'));
        $grid->column('users.nickname', __('用户'));
        $grid->column('cate', __('类型'))->using(['1'=>'产品','2'=>'文章']);
        $grid->column('name', __('名称'));
        $grid->column('phone', __('手机号'));
        $grid->column('created_at', __('点赞时间'));

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
        $show = new Show(With::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('users.nickname', __('用户'));
        $show->field('cate', __('类型'));
        $show->field('name', __('名称'));
        $show->field('phone', __('手机号'));
        $show->field('created_at', __('点赞时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new With());

        $form->number('user_id', __('User id'));
        $form->number('activity_id', __('Activity id'));
        $form->number('cate', __('Cate'))->default(1);
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));

        return $form;
    }
}

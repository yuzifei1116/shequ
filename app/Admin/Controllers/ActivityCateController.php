<?php

namespace App\Admin\Controllers;

use App\ActivityCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityCateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActivityCate());

        $grid->column('id', __('索引'));
        $grid->column('name', __('分类名称'));
        $grid->column('htm_id', __('所在页面'))->using([1 => '首页', 2 => '社区']);
        $grid->column('created_at', __('添加时间'));

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
        $show = new Show(ActivityCate::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('name', __('分类名称'));
        $show->field('htm_id', __('所在页面'));
        $show->field('created_at', __('添加时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ActivityCate());

        $form->text('name', __('分类名称'))->required();
        $form->select('htm_id', __('所在页面'))->options([1 => '首页', 2 => '社区'])->required();

        return $form;
    }
}

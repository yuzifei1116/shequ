<?php

namespace App\Admin\Controllers;

use App\ProCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProCateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProCate());

        $grid->column('id', __('索引'));
        $grid->column('title', __('名称'));
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
        $show = new Show(ProCate::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('title', __('名称'));
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
        $form = new Form(new ProCate());

        $form->text('title', __('名称'));

        return $form;
    }
}

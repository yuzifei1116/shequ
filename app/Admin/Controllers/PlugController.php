<?php

namespace App\Admin\Controllers;

use App\Plug;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PlugController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '首页轮播图';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Plug());

        $grid->column('id', __('索引'));
        $grid->column('img', __('图片'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('is_show', __('是否显示'))->switch([
            'on'=>['value' => 1, 'text' => '显示', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger']
        ]);
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
        $show = new Show(Plug::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('img', __('图片'));
        $show->field('is_show', __('是否显示'));
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
        $form = new Form(new Plug());

        $form->image('img', __('图片'))->required();
        $form->switch('is_show', __('是否显示'))->states([
            'on'=>['value' => 1, 'text' => '打开', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger']
        ]);

        return $form;
    }
}

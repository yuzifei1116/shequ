<?php

namespace App\Admin\Controllers;

use App\Activity;
use App\ActivityCate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity());

        $grid->column('id', __('索引'));
        $grid->column('cate.name', __('分类名称'));
        $grid->column('title', __('标题'));
        $grid->column('img', __('图片'))->lightbox(['width' => 50, 'height' => 50]);
        $grid->column('content', __('内容'));
        $grid->column('browse_count', __('浏览次数'));
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
        $show = new Show(Activity::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('cate_id', __('分类名称'));
        $show->field('title', __('标题'));
        $show->field('img', __('图片'));
        $show->field('content', __('内容'));
        $show->field('browse_count', __('浏览次数'));
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
        $form = new Form(new Activity());

        $form->select('cate_id', __('分类名称'))->options(\App\ActivityCate::get()->pluck('name', 'id'))->required();
        $form->text('title', __('标题'))->required();
        $form->image('img', __('图片'))->required();
        $form->ueditor('content', __('内容'))->required();

        return $form;
    }
}

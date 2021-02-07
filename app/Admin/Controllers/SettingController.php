<?php

namespace App\Admin\Controllers;

use App\Setting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SettingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '系统设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Setting());

        $grid->column('id', __('索引'));
        $grid->column('phone', __('联系电话'));
        $grid->column('content', __('关于'));
        $grid->column('trade', __('交易流程'));

        if(Setting::first()){

            $grid->disableCreateButton();

        }

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
        $show = new Show(Setting::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('phone', __('联系电话'));
        $show->field('content', __('内容'));
        $show->field('trade', __('交易流程'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Setting());

        $form->mobile('phone', __('联系电话'))->required();
        $form->ueditor('content', __('关于'))->required();
        $form->ueditor('trade', __('交易流程'))->required();

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Product;
use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Post\ProductPost;
use App\Admin\Actions\Post\Replicate;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('索引'));
        $grid->column('name', __('产品名称'));
        $grid->column('cate_id', __('产品分类'))->using(['1'=>'政信类','2'=>'地产类','3'=>'工商类','4'=>'资金池类','5'=>'逾期类']);
        $grid->column('rate_cate', __('收益分配方式'))->using(['1'=>'季度','2'=>'半年','3'=>'年度']);
        $grid->column('annualized', __('预计年化'))->help('单位：%');
        $grid->column('turn_money', __('金额'))->help('单位：万')->label('info');
        $grid->column('de_money', __('贴息金额'))->help('单位：万');
        $grid->column('end_time', __('合同到期日期'));
        $grid->column('suv_day', __('剩余天数'));
        $grid->column('remark', __('产品介绍'));
        $grid->column('is_site', __('是否交易'))->switch([
            'on'=>['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger']
        ]);
        $grid->column('phone', __('联系电话'));
        $grid->column('is_show', __('审核状态'))->using(['0'=>'待审核','1'=>'通过','2'=>'拒绝'])->dot([ 1 => 'success', 0 => 'danger','2'=>'info' ], 'default');
        $grid->column('reason', __('拒绝原因'));
        $grid->column('server', __('产品类型'))->using(['1'=>'转让','2'=>'求购']);
        $grid->column('users.nickname', __('用户'));
        $grid->column('browse_count', __('浏览次数'));
        $grid->column('created_at', __('添加时间'));

        $grid->column('审核')->action(ProductPost::class);//添加审核按钮

        $grid->column('拒绝')->action(Replicate::class);//添加拒绝按钮

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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('索引'));
        $show->field('name', __('产品名称'));
        $show->field('cate_id', __('产品分类'))->using(['1'=>'政信类','2'=>'地产类','3'=>'工商类','4'=>'资金池类','5'=>'逾期类']);
        $show->field('rate_cate', __('收益分配方式'))->using(['1'=>'季度','2'=>'半年','3'=>'年度']);
        $show->field('annualized', __('预计年化 单位：%'));
        $show->field('turn_money', __('金额 单位：万'));
        $show->field('de_money', __('金额 单位：万'));
        $show->field('suv_day', __('剩余天数'));
        $show->field('remark', __('产品信息'));
        $show->field('is_site', __('是否交易完成'))->using(['0'=>'否','1'=>'是']);
        $show->field('phone', __('联系电话'));
        $show->field('is_show', __('审核状态'))->using(['0'=>'待审核','1'=>'通过','2'=>'拒绝']);
        $show->field('reason', __('拒绝原因'));
        $show->field('server', __('产品类型'))->using(['1'=>'转让','2'=>'求购']);
        $show->field('users.nickname', __('用户'));
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
        $form = new Form(new Product());

        $form->text('name', __('产品名称'));
        $form->text('cate.title', __('产品分类'));
        $form->number('rate_cate', __('收益分配方式'));
        $form->number('annualized', __('预计年化 单位：%'));
        $form->number('turn_money', __('金额 单位：万'));
        $form->number('de_money', __('贴息金额 单位：万'));
        $form->text('end_time', __('预计到期日期'));
        $form->number('suv_day', __('剩余天数'));
        $form->text('remark', __('产品信息'));
        $form->switch('is_site', __('是否交易完成'))->states([
            'on'=>['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger']
        ]);
        $form->mobile('phone', __('联系电话'));
        $form->number('is_show', __('审核状态'));
        $form->number('server', __('产品类型'))->default(1);
        $form->number('user_id', __('用户'));
        $form->number('browse_count', __('浏览次数'));

        return $form;
    }
}

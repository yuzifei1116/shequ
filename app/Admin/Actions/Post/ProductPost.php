<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ProductPost extends RowAction
{
    public function handle(Model $model,Request $request)
    {

        if($model->is_show != 0) return $this->response()->error('该产品的状态不是待审核！')->refresh();
        $model->is_show = 1;

        $model->save();

        return $this->response()->success('审核成功')->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定审核？');
    }

    // 这个方法来根据`star`字段的值来在这一列显示不同的图标
    public function display($star)
    {
        return $star ? "<i class=\"fa fa-star-o\">审核</i>" : "<i class=\"fa fa-star\">审核</i>";
    }
}
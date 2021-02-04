<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Form;
use Illuminate\Http\Request;

class Replicate extends RowAction
{
    public function handle(Model $model,Request $request)
    {

        if($model->is_show == 1){
            
            return $this->response()->error('该产品已通过，无法修改！')->refresh();

        } 
        
        $model->is_show = 2;

        $model->save();

        return $this->response()->success('拒绝成功')->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定拒绝？');
    }

    // 这个方法来根据`star`字段的值来在这一列显示不同的图标
    public function display($star)
    {
        return $star ? "<i class=\"fa fa-star-o\">拒绝</i>" : "<i class=\"fa fa-star\" style=\"color:red\">拒绝</i>";
    }

}
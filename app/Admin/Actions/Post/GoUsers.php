<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GoUsers extends RowAction
{
    public $name = '回复';

    public function handle(Model $model,Request $request)
    {
        $content = $request->post('text');

        $id = \App\User::where('nickname','管理员')->where('openid','')->value('id');

        if(!$id){

            \App\User::create(['nickname'=>'管理员','avatar'=>env('APP_URL').'/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg']);

            $id = \App\User::where('nickname','管理员')->value('id');

        } 

        $data = \App\ActSpeaks::create([
            'user_id'   =>  $id,
            'userAct_id'  =>  $model->speak_id,
            'content'   =>  $content,
            'reply_id'  =>  $model->user_id,
            'comment_id'=>  $model->comment_id != 0 ? $model->comment_id : $model->id
        ]);

        if($data){

            return $this->response()->success('回复成功')->refresh();

        }else{

            return $this->response()->error('错误');

        }

    }

    public function form()
    {
        $this->textarea('text', '内容')->rules('required');
    }

    // 这个方法来根据`star`字段的值来在这一列显示不同的图标
    public function display($star)
    {
        return $star ? "<i class=\"fa fa-star-o\">回复</i>" : "<i class=\"\" style='color:red'>回复</i>";
    }

}
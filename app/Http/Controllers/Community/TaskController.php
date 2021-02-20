<?php

namespace App\Http\Controllers\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    
    /**
     * 产品剩余天数递减
     */
    public function dayInc(Request $request)
    {
        try {

            $data = \App\Product::where('suv_day','<>',0)->get();

            try {
                foreach($data as $k=>&$v){
                    $v->suv_day = $v->suv_day - 1;
                    $v->save();
                }
            } catch (\Throwable $th) {
                echo '成功了';
            }

            echo '成功了。。。。。。';
        } catch (\Throwable $th) {
            echo '失败！！！！！';
        }    
    }

}

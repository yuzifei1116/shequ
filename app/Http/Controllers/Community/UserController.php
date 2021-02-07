<?php

namespace App\Http\Controllers\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 个人信息
     */
    public function user(Request $request)
    {
        try {

            $user = $request->user;

            $user->phone = phone();

            $user->content = \App\Setting::value('content');
            
            return result($user);

        } catch (\Throwable $th) {
            
            return error();

        }
    }

    /**
     * 我的发布
     */
    public function user_pro(Request $request)
    {
        try {
            
            $limit = $request->limit ? $request->limit : 6; 

            $page  = $request->page ? $request->page - 1 : 0;

            if(!is_numeric($page)){
                return response()->json(['error'=>['message' => '参数错误!']]); 
            }

            $page   = $page < 0 ? 0 : $page ;

            $page   = $page * $limit;

            $data = \App\Product::where('user_id',$request->user->id)->where('server',1)->orderBy('id','desc')->offset($page)->limit($limit)->get();

            if($data){

                foreach($data as $k=>&$v){

                    $v['end_time'] = date('Y-m-d',$v['end_time']);

                    switch ($v['rate_cate']) {
                        case '1':
                            $v['rate_cate'] = '季度';
                            break;
        
                        case '2':
                            $v['rate_cate'] = '半年';
                            break;
        
                        case '3':
                            $v['rate_cate'] = '年度';
                            break;
                        
                        default:
                            # code...
                            break;
                    }

                    switch ($v['cate_id']) {
                        case '1':
                            $v['cate_name'] = '征信类';
                            break;
        
                        case '2':
                            $v['cate_name'] = '地产类';
                            break;
        
                        case '3':
                            $v['cate_name'] = '工商企业类';
                            break;
    
                        case '4':
                            $v['cate_name'] = '资金池类';
                            break;
                        
                        case '5':
                            $v['cate_name'] = '逾期类';
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }

            }

            return \result($data);

        } catch (\Throwable $th) {
            
            return error();

        }
    }
}

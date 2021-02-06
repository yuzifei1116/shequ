<?php

namespace App\Http\Controllers\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 首页
     */
    public function com_index(Request $request)
    {

        try {

            $data = array();
            
            //轮播图
            $data['img'] = \App\Plug::where('is_show',1)->orderBy('created_at','desc')->get();

            if($data['img']){

                foreach($data['img'] as $k=>&$v){

                    $v['img'] = env('APP_URL').'storage/'.$v['img'];
    
                }

            }

            //产品转让信息总数
            $data['turn_count'] = \App\Product::where('is_site',0)->where('is_show',1)->where('server',1)->count();
            
            //产品求购信息总数
            $data['buy_count'] = \App\Product::where('is_site',0)->where('is_show',1)->where('server',2)->count();

            //最新交易动态
            $data['new_dynamic'] = \App\Product::select('id','name','server')->where('is_site',1)->orderBy('trade_time','desc')->limit(8)->get();

            if($data['new_dynamic']){

                foreach($data['new_dynamic'] as $k=>&$v){

                    if($v['server'] == 1) $v['content'] = '[产品转让]'.$v['name'] ?? '[产品求购]'.$v['name'];

                    unset($v['name']);

                    unset($v['server']);
                        
                }

            }

            //最新转让信息
            $data['new_turn'] = \App\Product::where('is_site',0)->where('is_show',1)->where('server',1)->orderby('id','desc')->limit(10)->get();

            if($data['new_turn']){

                foreach($data['new_turn'] as $k=>&$v){
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
                }

            }

            //底部文章分类
            $data['cate'] = \App\ActivityCate::select('name')->limit(3)->where('htm_id',1)->get();

            return result($data); 
            
        } catch (\Throwable $th) {
            
            return error();

        }

    }

    /**
     * 自增浏览次数
     */
    public function line(Request $request)
    {
        try {
            
            if(!$request->id) return error('参数错误');

            if(!$request->type) return error('参数错误');

            //1产品 2文章
            if($request->type == 1) \App\Product::where('id',$request->id)->increment('browse_count');
                else \App\Activity::where('id',$request->id)->increment('browse_count');

            return \result('成功！！！');

        } catch (\Throwable $th) {
            
            return error();

        }
    }
}

<?php

namespace App\Http\Controllers\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    
    /**
     * 发布转让产品
     */
    public function release_product(Request $request)
    {
        try {

            $data = array();

            if(!$request->name) return error('请填写产品名称'); else $data['name'] = $request->name;

            if(!$request->rate_cate) return error('请填写收益分配方式'); else $data['rate_cate'] = $request->rate_cate;

            if(!$request->annualized) return error('请填写预计年化'); else $data['annualized'] = $request->annualized;

            if(!$request->turn_money) return error('请填写金额'); else $data['turn_money'] = $request->turn_money;

            if(!$request->end_time) return error('请填写预计到期日期'); else $data['end_time'] = strtotime($request->end_time);

            if(!$request->suv_day) return error('请填写剩余天数'); else $data['suv_day'] = $request->suv_day;

            if(!$request->cate_id) return error('请选择分类'); else $data['cate_id'] = $request->cate_id;

            if($request->remark) $data['remark'] = $request->remark;
            
            $data['phone'] = phone();
            
            $data['user_id'] = $request->user->id;

            $result = \App\Product::create($data);

            if($result) return result('发布成功'); else return error();

        } catch (\Throwable $th) {
            
            return error();

        }
    }

    /**
     * 产品列表
     */
    public function product(Request $request)
    {
        try {
            
            //发布产品列表
            $data['fa_product'] = \App\Product::where('is_site',0)->where('is_show',1)->where('server',1)->orderby('id','desc')->get();

            if($data['fa_product']){

                foreach($data['fa_product'] as $k=>&$v){

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

            return result($data['fa_product']);

        } catch (\Throwable $th) {
            
            return error();

        }
    }

    /**
     * 单个产品详情
     */
    public function productFirst(Request $request)
    {
        try {
            
            if(!$request->id) return error('请选择产品');

            $data = \App\Product::where('id',$request->id)->first();

            switch ($data['rate_cate']) {
                case '1':
                    $data['rate_cate'] = '季度';
                    break;

                case '2':
                    $data['rate_cate'] = '半年';
                    break;

                case '3':
                    $data['rate_cate'] = '年度';
                    break;
                
                default:
                    # code...
                    break;
            }

            $data['nickname'] = $data->users->nickname;

            $data['end_time'] = date('Y-m-d',$data['end_time']);

            $res = \App\With::where('user_id',$request->user->id)->where('activity_id',$request->id)->where('cate',1)->count() ?? 0;

            if($res == 0){
                $data['is_dian'] = 0;
            }else{
                $data['is_dian'] = 1;
            }

            return result($data);

        } catch (\Throwable $th) {
            
            return error();

        }
    }

}

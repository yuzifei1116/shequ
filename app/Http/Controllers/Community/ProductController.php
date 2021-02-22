<?php

namespace App\Http\Controllers\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

            if(!$request->annualized) return error('请填写合同收益'); else $data['annualized'] = $request->annualized;

            if(!$request->turn_money) return error('请填写金额'); else $data['turn_money'] = $request->turn_money;

            if(!$request->de_money) return error('请填写贴息金额'); else $data['de_money'] = $request->de_money;

            if(!$request->end_time) return error('请填写预计到期日期'); else $data['end_time'] = $request->end_time;

            if(!$request->cate_id) return error('请选择分类'); else $data['cate_id'] = $request->cate_id;

            $file = $request->file('file');
            
            if(!$file) return error('请选择图片');
            
            $path = Storage::putFile('public/images', $request->file('file'));
            
            $path = \substr($path,7);
            
            $data['img'] = $path;
            
            if($request->remark) $data['remark'] = $request->remark;

            if($request->get('server')) $data['server'] = $request->get('server');

            $data['suv_day'] = $this->diffBetweenTwoDays(time(),$data['end_time']);
            
            $data['phone'] = phone();
            
            $data['user_id'] = $request->user->id;

            $result = \App\Product::create($data);

            if($result) return result('发布成功');

        } catch (\Throwable $th) {
            
            return error();

        }
    }

    /**
     * 求两个日期之间相差的天数
     * (针对1970年1月1日之后，求之前可以采用泰勒公式)
     * @param string $day1
     * @param string $day2
     * @return number
     */
    public function diffBetweenTwoDays ($day1, $day2)
    {

        $second1 = $day1;
        $second2 = strtotime($day2);
            
        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        
        return ($second1 - $second2) / 86400;

    }

    /**
     * 类别对应产品列表
     */
    public function type_product(Request $request)
    {
        try {
            
            if(!$request->type) return \error('请选择类别');

            if(!$request->c){
                $data = \App\Product::where('is_site',0)->where('is_show',1)->where('suv_day','<>',0)->where('server',1)->orderBy('id','desc')->where('cate_id',$request->type)->get();

                try {
                    
                    foreach($data as $k=>&$v){

                        if($v['img']){
                            $v['img'] = env('APP_URL').'storage/'.$v['img'];
                        }
                        
                        switch ($v['cate_id']) {
                            case '1':
                                $v['cate_name'] = '政信类';
                                break;
            
                            case '2':
                                $v['cate_name'] = '地产类';
                                break;
            
                            case '3':
                                $v['cate_name'] = '工商类';
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
                } catch (\Throwable $th) {
                
                    return \result($data);
        
                }
            }else{

                $limit = $request->limit ? $request->limit : 6; 

                $page  = $request->page ? $request->page - 1 : 0;

                if(!is_numeric($page)){
                    return response()->json(['error'=>['message' => '参数错误!']]); 
                }

                $page   = $page < 0 ? 0 : $page ;

                $page   = $page * $limit;

                $data = \App\Activity::where('cate_id',$request->type)->offset($page)->limit($limit)->get();

                if($data){

                    foreach($data as $k=>&$v){
    
                        $v['img'] = env('APP_URL').'storage/'.$v['img'];
    
                    }

                }

                return \result($data);

            }
            

            return \result($data);

        } catch (\Throwable $th) {

            return error();

        }
    }

    /**
     * 我的收藏
     */
    public function user_withs(Request $request)
    {
        try {
            
            $data = \App\With::where('user_id',$request->user->id)->where('cate',1)->get();

            if($data){
                foreach($data as $k=>&$v){
                    $v['pro'] = \App\Product::where('id',$v['activity_id'])->first();
                    
                    if($v['pro']['img']){
                        $v['pro']['img'] = env('APP_URL').'storage/'.$v['pro']['img'];
                    }
                    switch ($v['pro']['cate_id']) {
                        case '1':
                            $v['pro']['cate_name'] = '政信类';
                            break;
        
                        case '2':
                            $v['pro']['cate_name'] = '地产类';
                            break;
        
                        case '3':
                            $v['pro']['cate_name'] = '工商类';
                            break;
    
                        case '4':
                            $v['pro']['cate_name'] = '资金池类';
                            break;
                        
                        case '5':
                            $v['pro']['cate_name'] = '逾期类';
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }
            }

            return result($data);
            
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
            $data = \App\Product::where('is_site',0)->where('is_show',1)->where('suv_day','<>',0)->where('server',1)->orderBy('id','desc')->get();

            if($data){

                foreach($data as $k=>&$v){

                    if($v['img']){
                        $v['img'] = env('APP_URL').'storage/'.$v['img'];
                    }

                    switch ($v['cate_id']) {
                        case '1':
                            $v['cate_name'] = '政信类';
                            break;
        
                        case '2':
                            $v['cate_name'] = '地产类';
                            break;
        
                        case '3':
                            $v['cate_name'] = '工商类';
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

            return result($data);

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

            if($data['img']){
                $data['img'] = env('APP_URL').'storage/'.$data['img'];
            }

            $data['nickname'] = $data->users->nickname ?? '';

            $data['phone'] = phone();

            if($data['remark'] == '') $data['remark'] = '暂无'; 

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

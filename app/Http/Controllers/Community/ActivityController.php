<?php

namespace App\Http\Controllers\Community;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * 文章列表
     */
    public function actList(Request $request)
    {
        try {

            //轮播图
            $data['img'] = \App\Plug::where('is_show',1)->orderBy('created_at','desc')->get();

            if($data['img']){

                foreach($data['img'] as $k=>&$v){

                    $v['img'] = env('APP_URL').'storage/'.$v['img'];
    
                }

            }

            $limit = $request->limit ? $request->limit : 10; 

            $page  = $request->page ? $request->page - 1 : 0;

            if(!is_numeric($page)){
                return response()->json(['error'=>['message' => '参数错误!']]); 
            }

            $page   = $page < 0 ? 0 : $page ;

            $page   = $page * $limit;

            $data['cate'] = \App\ActivityCate::where('htm_id',2)->get();

            foreach($data['cate'] as $k=>&$v){

                $v['img'] = env('APP_URL').'storage/'.$v['img'];

            }

            $data['act'] = \App\UserAct::where('is_show',1)->offset($page)->limit($limit)->get();

            if($data['act']){

                foreach($data['act'] as $kk=>&$vv){

                    $vv['nickname'] = \App\User::where('id',$vv['user_id'])->value('nickname');

                    $vv['avatar'] = \App\User::where('id',$vv['user_id'])->value('avatar');

                    $vv['img'] = env('APP_URL').'storage/'.$vv['img'];

                    //评论区
                    $vv['speak'] = \App\ActSpeaks::where('userAct_id',$vv['id'])->where('reply_id',0)->where('comment_id',0)->orderBy('created_at','desc')->where('is_show',1)->get();
                    
                    if($vv['speak']){

                        foreach($vv['speak'] as $k=>&$v){
                            
                            $v['user'] = $v->users->nickname;

                            $v['user_avatar'] = $v->users->avatar;

                            //顶级
                            $v['user_speak'] = \App\ActSpeaks::where('userAct_id',$request->id)->where('comment_id',$v->id)->orderBy('created_at','asc')->where('is_show',1)->get();
                            
                            unset($v['users']);

                            //副级
                            if($v['user_speak']){

                                foreach($v['user_speak'] as $key=>&$value){

                                    $value['user'] = $value->users->nickname;
            
                                    $value['user_avatar'] = $value->users->avatar;
            
                                    $value['reply'] = $value->user_reply->nickname;
            
                                    $value['reply_avatar'] = $value->user_reply->avatar;

                                    unset($value['user_reply']);

                                    unset($value['users']);
            
                                }

                            }
                            
                        }
                    }
                }

            }

            return result($data);

        } catch (\Throwable $th) {
            
            return error();
            // return $th->getMessage();

        }
    }

    /**
     * 发布动态
     */
    public function pushComment(Request $request)
    {
        try {
            
            if(!$request->title) return error('请填写动态');

            $file = $request->file('file');
            
            if($file){

                $path = Storage::putFile('public/images', $request->file('file'));
                
                $path = \substr($path,7);
                
                $push = new \App\UserAct;

                $push->title = $request->title;

                $push->user_id = $request->user->id;

                $push->img = $path;

                $push->save();

            }else{

                $push = new \App\UserAct;

                $push->title = $request->title;
                
                $push->user_id = $request->user->id;

                $push->save();

            }

            return result('发布成功,请等待审核');

        } catch (\Throwable $th) {
            
            return error();
            // return $th->getMessage();

        }
    }

    /**
     * 文章详情
     */
    public function actFirst(Request $request)
    {
        try {
            
            if(!$request->id) return error('请选择文章');

            $data = \App\Activity::where('id',$request->id)->first();

            //点赞总数
            $data['with'] = \App\With::where('activity_id',$request->id)->count() ?? 0;

            //用户是否点赞
            $data['is_with'] = \App\With::where('activity_id',$request->id)->where('user_id',$request->user->id)->where('cate',2)->count() ?? 0;

            //评论区
            $data['speak'] = \App\UserSpeak::where('speak_id',$request->id)->where('reply_id',0)->where('comment_id',0)->orderBy('created_at','desc')->where('is_show',1)->get();
            
            if($data['speak']){

                foreach($data['speak'] as $k=>&$v){
                    
                    $v['user'] = $v->users->nickname;

                    $v['user_avatar'] = $v->users->avatar;

                    //顶级
                    $v['user_speak'] = \App\UserSpeak::where('speak_id',$request->id)->where('comment_id',$v->id)->orderBy('created_at','asc')->where('is_show',1)->get();
                    
                    unset($v['users']);

                    //副级
                    if($v['user_speak']){

                        foreach($v['user_speak'] as $key=>&$value){

                            $value['user'] = $value->users->nickname;
    
                            $value['user_avatar'] = $value->users->avatar;
    
                            $value['reply'] = $value->user_reply->nickname;
    
                            $value['reply_avatar'] = $value->user_reply->avatar;

                            unset($value['user_reply']);

                            unset($value['users']);
    
                        }

                    }
                    
                }

            }

            return result($data);

        } catch (\Throwable $th) {
            
            return error();
            // return $th->getMessage();

        }
    }

    /**
     * 评论
     */
    public function speak(Request $request)
    {
        try {
            
            if(!$request->speak_id) return error('请选择文章');

            if(!$request->content) return error('请填写评论内容');

            $reply_id = $request->reply_id ?? 0;

            $comment_id = $request->comment_id ?? 0;

            if($request->a){

                $res = \App\ActSpeaks::create([
                    'user_id'   =>  $request->user->id,
                    'userAct_id'  =>  $request->speak_id,
                    'content'   =>  $request->content,
                    'reply_id'  =>  $reply_id,
                    'comment_id'=>  $comment_id
                ]);

            }else{

                $res = \App\UserSpeak::create([
                    'user_id'   =>  $request->user->id,
                    'speak_id'  =>  $request->speak_id,
                    'content'   =>  $request->content,
                    'reply_id'  =>  $reply_id,
                    'comment_id'=>  $comment_id
                ]);

            }

            if($res) return result('评论成功');

        } catch (\Throwable $th) {
            
            return error();

        }
    }

    /**
     * 点赞
     */
    public function user_with(Request $request)
    {
        try {

            if(!$request->cate) return error('请选择点赞类型');
            
            if(!$request->id) return error('请选择id');

            if($request->cate == 1){

                $res = \App\With::where('user_id',$request->user->id)->where('activity_id',$request->id)->where('cate',1)->count() ?? 0;

            }else{

                $res = \App\With::where('user_id',$request->user->id)->where('activity_id',$request->id)->where('cate',2)->count() ?? 0;

            }

            if($res != 0) return error('已经点过赞');

            if($request->cate == 1){

                $data = \App\With::create(['user_id'=>$request->user->id,'activity_id'=>$request->id,'name'=>\App\Product::where('id',$request->id)->value('name'),'phone'=>$request->user->tel]);

            }else{

                $data = \App\With::create(['user_id'=>$request->user->id,'activity_id'=>$request->id,'name'=>\App\Activity::where('id',$request->id)->value('title'),'phone'=>$request->user->tel,'cate'=>2]);

            }

            if($data) return result('点赞成功');

        } catch (\Throwable $th) {
            
            return error();

        }
    }

    
}

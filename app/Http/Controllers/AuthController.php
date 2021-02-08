<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Factory;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $app = null;

    public function __construct()
    {
        $wechat_config = [
            'app_id'    => 'wx673213a4ff469751',
            'secret'    => 'ff6841722f8706716089b1168819e96e'
        ];

        $this->app = Factory::miniProgram($wechat_config);
    }

    /**
     * 用户登陆授权
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->only('iv', 'encryptedData');

        $validator = Validator::make($input, [
            'iv'            => 'required',
            'encryptedData' => 'required',
        ]);

        if($validator->fails()) {
            return error((string) $validator->errors()->first());
        }
        
        $session_key = $request->user['session_key'];

        if(!$session_key) {
            return error('session_key 不存在');
        }
        
        try {
            $data = $this->app->encryptor->decryptData(
                        $session_key,
                        $input['iv'],
                        $input['encryptedData']
                    );
        } catch (\Exception $e) {
            return error('session_key 无效');
        }

        if(!isset($data['openId'])) {
            return error('获取 openid 错误');
        }

        $model =    User::where('openid', $data['openId'])
                        ->first();
        
        $model->nickname    = $data['nickName'];
        $model->avatar      = $data['avatarUrl'];
        $model->token       = Str::random(32);

        if(!$model->save()) {
            return error();
        }

        return  result([
                    'user' => [
                        'nickname'  => $model->nickname,
                        'avatar'    => $model->avatar,
                    ],
                    'token'=>[
                        'token'     =>  $model->token
                    ]
                ]);
    }

    /**
     * 获取手机号
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user_phone(Request $request)
    {
        $input = $request->post();

        $validator = Validator::make($input, [
            'iv'            => 'required',
            'encryptedData' => 'required',
        ]);

        if($validator->fails()) {
            return error((string) $validator->errors()->first());
        }
        
        $session_key = $request->user['session_key'];

        if(!$session_key) {
            return error('session_key 不存在');
        }
        
        try {
            $data = $this->app->encryptor->decryptData(
                        $session_key,
                        $input['iv'],
                        $input['encryptedData']
                    );
        } catch (\Exception $e) {
            return error('session_key 无效');
        }

        if(!isset($data['openId'])) {
            return error('获取 openid 错误');
        }
        dd($data);
        $model =    User::where('openid', $data['openId'])
                        ->first();
        
        $model->nickname    = $data['nickName'];
        $model->avatar      = $data['avatarUrl'];
        $model->token       = Str::random(32);

        if(!$model->save()) {
            return error();
        }

        return  result([
                    'user' => [
                        'nickname'  => $model->nickname,
                        'avatar'    => $model->avatar,
                    ],
                    'token' => $model->token,
                ]);
    }

    /**
     * code
     * code 兑换 session_key 和 openid ，如果 openid 用户不存在创建一个新的
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function code(Request $request)
    {
        try {
            
            $input = $request->only('code');

            $validator = Validator::make($input, [
                'code'  => 'required',
            ]);

            try {
                if($validator->fails()) {
                    return error((string) $validator->errors()->first());
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
            
            try {
                $data = $this->app->auth->session($input['code']);
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            if(isset($data['errcode'])) {
                switch ($data['errcode']) {
                    case 40029:
                        // 这里需要注意的是 code 只能换取一次
                        // 如果一直报 40029 需要前后端检查 appid 是否一致
                        return error('code 无效');
                        break;

                    default:
                        return error('请求频繁');
                        break;
                }
            }

            $user = User::where('openid', $data['openid'])
                        ->first();

            if(!$user) {
                $user           = new User;
                $user->openid   = $data['openid'];
            }

            $user->session_key = $data['session_key'];
            $user->token       = Str::random(32);

            if(!$user->save()) {
                return error();
            }

            return  result([
                        'token' => $user->token,
                    ]);

        } catch (\Throwable $th) {
            
            return $th->getMessage();

        }
        
    }
}

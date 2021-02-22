<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class WechatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        
        $user = User::where('token', $token)
                    ->first();
        // dd($user);
        if(!$user) {
            return error('请登陆', 401);
        }

        if($user->status != 1) {
            return error('当前账户暂时无法使用');
        }

        $request->user  = $user;
        $request->uid   = $user->getKey();

        return $next($request);
    }
}

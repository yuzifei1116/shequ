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
            
            return result($request->user);

        } catch (\Throwable $th) {
            
            return error();

        }
    }
}

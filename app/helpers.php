<?php

if(!function_exists('result')) {
    /**
     * 返回数据
     *
     * @param string|array  $data  数据
     * @param int  $status  状态码
     * @return \Illuminate\Http\Response
     */
    function result($data = null, int $status = 200) {
        return response()->json(
            is_null($data) ? ['code' => 200] : ['code' => 200, 'data' => $data],
            $status
        );
    }
}

if(!function_exists('error')) {
    /**
     * 返回错误
     *
     * @param string  $msg  错误信息
     * @param int  $status  状态码
     * @return \Illuminate\Http\Response
     */
    function error($msg = '系统错误', int $status = 400) {
        return response()->json(
            ['code' => 400, 'message' => $msg],
            $status
        );
    }
}

if(!function_exists('phone')) {
    /**
     * 返回联系方式
     * @return \Illuminate\Http\Response
     */
    function phone() {
        return \App\Setting::orderBy('id','desc')->value('phone');
    }
}

?>
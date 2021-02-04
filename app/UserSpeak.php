<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSpeak extends Model
{
    //
    protected $guarded = [];

    protected $table = 'user_speaks';

    /**
     * 评论表反相关联用户表
     */
    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * 评论表反相关联用户表
     */
    public function user_reply()
    {
        return $this->belongsTo('App\User','reply_id','id');
    }

    /**
     * 评论表反向关联文章表
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity','speak_id','id');
    }

}

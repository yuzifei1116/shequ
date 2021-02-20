<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActSpeaks extends Model
{
    //
    protected $guarded = [];

    protected $table = 'act_speaks';

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

}

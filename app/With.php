<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class With extends Model
{
    protected $guarded = [];

    /**
     * 点赞表关联用户表
     */
    public function users()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}

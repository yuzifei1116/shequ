<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    /**
     * 产品表反向关联用户表
     */
    public function users()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    /**
     * 产品表反向关联分类表
     */
    public function cate()
    {
        return $this->belongsTo('App\ProCate','cate_id','id');
    }

}

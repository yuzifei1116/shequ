<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $table = 'activitys';

    /**
     * 文章表反向关联文章分类表
     */
    public function cate()
    {
        return $this->belongsTo('App\ActivityCate','cate_id','id');
    }
}

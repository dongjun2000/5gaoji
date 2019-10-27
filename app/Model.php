<?php

namespace App;


class Model extends \Illuminate\Database\Eloquent\Model
{
    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
}
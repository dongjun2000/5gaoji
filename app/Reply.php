<?php

namespace App;

class Reply extends Model
{
    protected $fillable = ['content', 'topic_id'];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}

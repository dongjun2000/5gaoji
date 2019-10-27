<?php

namespace App\Observers;

use App\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function created(Reply $reply)
    {
//        $reply->topic()->increment('reply_count', 1);

        // 统计后入库
        $reply->topic->updateReplyCount();

        // 如果要通知的人是当前用户，就不必通知了！
        if (!$reply->user->isAuthorOf($reply->topic)) {
            // 通知话题作者有新的评论
            $reply->topic->user->notify(new TopicReplied($reply));
        }
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->updateReplyCount();
    }
}

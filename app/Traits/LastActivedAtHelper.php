<?php
/** ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * |   Software: [DJPHP framework]
 * |    Product: 梦航云 - 专业的企业多端解决方案
 * |       site: www.246ha.com www.5gaoji.com www.huizuofan.com
 * | ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * |     Author: 董俊 <418826102@qq.com>
 * |     WeChat: dongjunweibo
 * |      Weibo: http://weibo.com/246ha
 * |       Time: 2019-10-29 22:51
 ** ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */

namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    // 缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    /**
     * 记录网站用户最后活动时间
     *
     * 按天分割记录到 Redis
     */
    public function recordLastActivedAt()
    {
        // 获取今天的日期，如 2019-10-29
        $date = Carbon::now()->toDateString();

        // Redis 哈希表的命名，如：larabbs_last_actived_at_2019-10-29
        $hash = $this->getHashFormDateString($date);

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 获取当前时间，如：2019-10-29 23:05:49
        $now = Carbon::now()->toDateTimeString();

        // 获取 Redis 中指定 hash key 存储的所有值
        // dd(Redis::hGetAll($hash));

        // 数据写入 Redis「Hash数据结构」，字段已存在会被更新
        Redis::hSet($hash, $field, $now);
    }

    /**
     * 同步 Redis 中记录昨天最后活跃的用户时间到数据库
     */
    public function syncUserActivedAt()
    {
        // 获取昨天的日期，格式如 2019-10-28
        $yesterday_date = Carbon::yesterday()->toDateString();

        // Redis 哈希表的命名，如：larabbs_last_actived_at_2019-10-28
        $hash = $this->getHashFormDateString($yesterday_date);

        // 从 Redis 中获取所有哈希表里的数据
        $dates = Redis::hGetAll($hash);

        // 遍历，并同步到数据库中
        foreach ($dates as $user_id => $actived_at) {
            // 去掉字段前缀，如从 user_1 得到 1
            $user_id = ltrim($user_id, $this->field_prefix);

            // 只有当用户存在时才更新到数据库中
            if ($user = $this->find($user_id)) {
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        // 以数据库为中心的存储，既已同步，即可删除
        Redis::del($hash);
    }

    /**
     * 访问器 --
     *
     * @param $value
     */
    public function getLastActivedAtAttribute($value)
    {
        // 获取今天的日期，格式如：2019-10-28
        $date = Carbon::now()->toDateString();

        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        $hash = $this->getHashFormDateString($date);

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 优先选择 Redis 的数据，否则使用数据库中的
        $datetime = Redis::hGet($hash, $field) ?: $value;

        if ($datetime) {
            // 如果存在的话，返回时间对应的 Carbon 实体
            return new Carbon($datetime);
        } else {
            // 否则使用用户注册时间
            return $this->created_at;
        }
    }

    protected function getHashFormDateString($date)
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2019-10-28
        return $this->hash_prefix . $date;
    }

    protected function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}
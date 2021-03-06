<?php

use App\User;
use App\Topic;
use App\Category;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 所有用户 ID 数组，如：[1, 2, 3]
        $user_ids = User::all()->pluck('id')->toArray();

        // 所有分类 ID 数组，如：[1, 2, 3]
        $category_id = Category::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index) use ($user_ids, $category_id, $faker) {
                // 从用户 ID 数组中随机取出一个并赋值
                $topic->user_id = $faker->randomElement($user_ids);

                // 话题分类，同上
                $topic->category_id = $faker->randomElement($category_id);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Topic::insert($topics->toArray());
    }
}

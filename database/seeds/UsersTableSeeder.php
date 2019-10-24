<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->times(10)->create();

        // 单独处理第一个用户的数据
        $user = \App\User::find(1);
        $user->name = 'dongjunjun';
        $user->email = 'admin@246ha.com';
        $user->save();
    }
}

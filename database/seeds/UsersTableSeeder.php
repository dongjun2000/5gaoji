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

        // 初始化用户角色，将1号用户指派为"站长"
        $user->assignRole('Founder');

        // 将 2 号用户指派为 "管理员"
        $user = \App\User::find(2);
        $user->assignRole('Maintainer');
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // 生成数据集合
        $users = factory(User::class)->times(10)->create();

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'CalDey';
        $user->email = 'caldey@qq.com';
        $user->avatar = 'http://yixinwen.test/uploads/images/avatars/202011/09/1_1604927122_SCXiatbIHr.jpg';
        $user->save();
    }
}

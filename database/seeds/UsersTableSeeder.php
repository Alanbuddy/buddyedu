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
        $this->seedAdmin();
        $this->seedMerchantAdmin();
        $this->seedTeachers();
        $this->seedUser();
    }

    public function seedUser()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => 'user ' . str_random(4),
                'email' => str_random(10) . '@gmail.com',
                'phone' => '1' . rand(1000000000, 9999999999),
                'password' => bcrypt('secret'),
                'gender' => $i % 2 == 0 ? 'male' : 'female',
                'birthday' => date('Y-m-d H:i:s'),
                'api_token' => \Faker\Provider\Uuid::uuid(),
            ]);
        }
    }

    public function seedTeachers()
    {
        DB::table('users')->insert([
            'name' => '贾金莉',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '17610076052',
            'birthday'=>'1972-08-08',
            'gender'=>'male',
            'extra'=>'{"cv": "北京理工大学教师\n旅法艺术家、学者\n全国高校美育学会会员、北京高校美学学会会员", "id": "123112344211341234", "title": "教授", "school": "北京理工大学教师", "introduction": "北京理工大学教师", "teaching_age": "12", "certificate_id": "1234123413"}',
            'password' => bcrypt('secret'),
            'merchant_id' => 1,
            'api_token' => 'da262427-88c6-356a-a431-8686856c81b3',
        ]);
        DB::table('users')->insert([
            'name' => '侯佩岑',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'birthday'=>'1982-08-08',
            'gender'=>'male',
            'extra'=>'{"cv": "儿童美术教学经验长达 12 年 中央美术学院博士毕业 二胎宝妈, 美育专家，艺术家 ", "id": "123192344211341234", "title": "美育专家", "school": "中央美术学院", "introduction": "北京理工大学教师", "teaching_age": "12", "certificate_id": "1234123413"}',
            'merchant_id' => 1,
            'api_token' => 'za262427-88c6-356a-a431-8686856c81b5',
        ]);
        DB::table('users')->insert([
            'name' => '刘亚男',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'birthday'=>'1972-08-08',
            'gender'=>'male',
            'extra'=>'{"cv": "大连外国语大学英语专业八级， 史家小学课外课教师5 年高端幼儿园（ 加拿大国际学校）讲师教学经验德国 HABA 品牌资深培训讲师和桌游翻译师", "id": "123192344211341234", "title": "德国 HABA 品牌资深培训讲师和桌游翻译师", "school": "中央美术学院", "introduction": "北京理工大学教师", "teaching_age": "10", "certificate_id": "1234123413"}',
            'merchant_id' => 1,
            'api_token' => 'za262427-88c6-356a-a431-8686856c81b6',
        ]);
    }

    public function seedMerchantAdmin()
    {
        DB::table('users')->insert([
            'name' => '田纯',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '13470079150',
            'password' => bcrypt('secret'),
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
        DB::table('users')->insert([
            'name' => '蔡德凤',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '13693395551',
            'password' => bcrypt('secret'),
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
        DB::table('users')->insert([
            'name' => '于导',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '13811089551',
            'password' => bcrypt('secret'),
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
    }

    public function seedAdmin()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '18911209450',
            'password' => bcrypt('secret'),
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        ]);
    }
}

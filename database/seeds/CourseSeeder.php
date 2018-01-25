<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
           'name'=>'BUDDY动物园',
            'description'=>'神笔马良--《BUDDY动物园》是由玩伴科技人工智能研究院打造的AR儿童教育品牌之一。BUDDY动物园寓意为一个能遇见所有奇妙动物的乐园，一个充满奇思妙想的国度。玩伴科技以教育为初衷，以科技为载体，以技术为媒介，带领孩子们走进充满奇遇和惊喜的魔力动物世界。',
            'detail'=>'<p><img src="/storage/2018-01-17/dd/2c/2018-01-17_093834Screenshot from 2018-01-17 09-38-23.png" style="max-width:100%;">神笔马良--《BUDDY动物园》是由玩伴科技人工智能研究院打造的AR儿童教育品牌之一。BUDDY动物园寓意为一个能遇见所有奇妙动物的乐园，一个充满奇思妙想的国度。玩伴科技以教育为初衷，以科技为载体，以技术为媒介，带领孩子们走进充满奇遇和惊喜的魔力动物世界。</p> ',
            'guide_price'=>'guide price 2000',
            'lessons_count'=>12,
            'status'=>'draft',
            'proportion'=>0.3,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
        ]);
    }
}

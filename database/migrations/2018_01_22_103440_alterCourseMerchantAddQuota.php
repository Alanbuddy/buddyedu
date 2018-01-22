<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCourseMerchantAddQuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_merchant', function (Blueprint $table) {
            $table->unsignedInteger('quantity')->nullable()->comment('学生账号预售数量');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_merchant', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
}

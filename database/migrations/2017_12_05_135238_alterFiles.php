<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->unsignedInteger('schedule_id')->nullable();
            $table->unsignedInteger('merchant_id')->nullable();
            $table->unsignedInteger('point_id')->nullable();
            $table->unsignedInteger('student_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('schedule_id');
            $table->dropColumn('merchant_id');
            $table->dropColumn('point_id');
            $table->dropColumn('student_id');
        });
    }
}

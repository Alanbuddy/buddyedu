<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quota')->nullable()->comment('学生限额');
            $table->timestamp('begin')->nullable();
            $table->timestamp('end')->nullable();
            $table->string('status')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('course_id')->comment('课程ID');
            $table->unsignedInteger('merchant_id')->comment('机构ID');
            $table->unsignedInteger('point_id')->comment('教学点ID');

            $table->foreign('course_id')->references('id')->on('courses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('merchant_id')->references('id')->on('merchants')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('point_id')->references('id')->on('points')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}

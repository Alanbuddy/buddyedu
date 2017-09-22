<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('文件名');
            $table->string('mime')->nullable()->comment('文件MIME类型');
            $table->string('extension')->nullable()->comment('文件扩展名');
            $table->bigInteger('size')->nullable();
            $table->string('path')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->integer('user_id')->unsigned()->comment('创建文件的用户ID');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}

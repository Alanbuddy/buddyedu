<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantPoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_point', function (Blueprint $table) {
            $table->unsignedInteger('merchant_id');
            $table->unsignedInteger('point_id');
            $table->timestamps();
            $table->foreign('point_id')->references('id')->on('points')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('merchant_id')->references('id')->on('merchants')
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
        Schema::dropIfExists('merchant_point');
    }
}

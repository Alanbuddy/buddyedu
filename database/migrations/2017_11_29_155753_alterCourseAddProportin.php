<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCourseAddProportin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedInteger('lessons_count')->nullable();
            $table->float('proportion')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('proportion');
            $table->dropColumn('url');
            $table->dropColumn('icon');
            $table->dropColumn('detail');
        });
    }
}

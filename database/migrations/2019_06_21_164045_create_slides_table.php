<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->engine = 'innodb';
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('pic',1000)->default('')->comment('图片');
            $table->unsignedInteger('event_id')->default(0)->comment('活动id');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `slides` COMMENT '鲸活动：轮播图'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}

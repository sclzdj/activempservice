<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'innodb';
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('describe',1000)->default('')->comment('描述');
            $table->string('pic',1000)->default('')->comment('图片');
            $table->text('content')->comment('内容');
            $table->unsignedInteger('pv')->default(0)->comment('点击数');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `events` COMMENT '鲸活动：活动'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

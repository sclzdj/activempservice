<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'innodb';
            $table->increments('id');
            $table->string('nickName')->default('')->comment('昵称');
            $table->string('avatarUrl', 1000)->default('')->comment('头像');
            $table->unsignedTinyInteger('gender')->default(0)->comment('【0:未知;1:是2:女】');
            $table->string('province')->default('')->comment('地区');
            $table->string('openid')->default('')->comment('小程序openid');
            $table->string('session_key')->default('')->comment('小程序session_key');
            $table->rememberToken();
            $table->timestamps();
        }
        );
        DB::statement("ALTER TABLE `users` COMMENT '鲸活动：用户'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}

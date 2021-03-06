<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 32)->unique()->comment('openid');
            $table->string('session_key', 50)->nullable()->comment('session_key');
            $table->string('avatar', 255)->nullable()->comment('头像');
            $table->string('nickname', 255)->index()->comment('昵称');
            $table->unsignedTinyInteger('sex')->nullable()->default(1)->comment('性别 0 未知 1 男 2女');
            $table->string('tel', 11)->index()->nullable()->comment('手机');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态');
            $table->string('token', 32)->nullable()->unique()->comment('令牌');
            $table->timestamps();
            $table->softDeletes();
        });
        \DB::statement("ALTER TABLE `users` comment '用户表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

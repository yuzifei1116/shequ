<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSpeaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_speaks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('speak_id')->nullable()->comment('社区id');

            $table->bigInteger('user_id')->nullable()->comment('用户id');

            $table->bigInteger('reply_id')->default(0)->comment('被评论用户id');

            $table->bigInteger('comment_id')->default(0)->comment('评论id');

            $table->string('content')->nullable()->comment('评论内容');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `user_speaks` comment '社区评论表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_speaks');
    }
}

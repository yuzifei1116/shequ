<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActSpeaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('act_speaks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('userAct_id')->nullable()->comment('动态id');

            $table->bigInteger('user_id')->nullable()->comment('用户id');

            $table->bigInteger('reply_id')->default(0)->comment('被评论用户id');

            $table->bigInteger('comment_id')->default(0)->comment('评论id');

            $table->string('content')->nullable()->comment('评论内容');

            $table->bigInteger('is_show')->default(0)->comment('是否显示');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `act_speaks` comment '动态评论表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('act_speaks');
    }
}

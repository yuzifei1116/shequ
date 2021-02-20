<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_acts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title')->nullable()->comment('文字');

            $table->string('img')->nullable()->comment('图片');

            $table->bigInteger('user_id')->nullable()->comment('用户id');

            $table->bigInteger('is_show')->default(0)->comment('0待审核 1已审核 2已拒绝');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `user_acts` comment '用户动态表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_acts');
    }
}

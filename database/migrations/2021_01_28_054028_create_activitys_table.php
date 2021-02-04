<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitys', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('cate_id')->nullable()->comment('分类id');

            $table->bigInteger('act_id')->nullable()->comment('1首页 2社区');

            $table->string('title')->nullable()->comment('标题');

            $table->longText('content')->nullable()->comment('文章内容');

            $table->bigInteger('browse_count')->default(0)->comment('浏览次数');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `activitys` comment '文章表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activitys');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_cates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable()->comment('分类名称');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `activity_cates` comment '文章分类表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_cates');
    }
}

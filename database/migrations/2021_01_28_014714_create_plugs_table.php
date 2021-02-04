<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('img')->nullable()->comment('轮播图');

            $table->bigInteger('is_show')->default(1)->comment('是否显示');

            $table->timestamps();
        });
        \DB::statement("ALTER TABLE `plugs` comment '首页轮播图表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugs');
    }
}

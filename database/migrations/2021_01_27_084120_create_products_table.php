<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable()->comment('产品名称');

            $table->bigInteger('rate_cate')->default(0)->comment('收益分配方式 1季度 2半年 3年度');

            $table->bigInteger('annualized')->default(0)->comment('预计年化 单位：%');
            
            $table->bigInteger('turn_money')->default(0)->comment('转让金额 单位：万');

            $table->string('end_time')->nullable()->comment('预计到期日期');

            $table->bigInteger('suv_day')->default(0)->comment('剩余天数');

            $table->string('remark')->nullable()->comment('补充内容');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

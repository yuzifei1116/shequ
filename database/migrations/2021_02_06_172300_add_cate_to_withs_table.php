<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCateToWithsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withs', function (Blueprint $table) {
            $table->bigInteger('cate')->default(1)->comment('1产品 2文章')->after('activity_id');
            $table->string('name')->nullable()->comment('名称')->after('cate');
            $table->string('phone')->nullable()->comment('电话')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withs', function (Blueprint $table) {
            //
        });
    }
}

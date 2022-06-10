<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoteAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promote_ads', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('ads_id');
            $table->integer('package_id');
            $table->string('order_id', 10);
            $table->integer('category_id')->nullable();
            $table->integer('duration');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('promote_ads');
    }
}

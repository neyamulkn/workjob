<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 10);
            $table->integer('user_id');
            $table->integer('package_id');
            $table->integer('category_id')->nullable();
            $table->integer('total_ads');
            $table->integer('remaining_ads');
            $table->integer('duration');
            $table->decimal('price', 8,2);
            $table->string('currency', 6);
            $table->string('currency_sign', 3);
            $table->string('payment_method', 20)->default('pending');
            $table->string('tnx_id', 55)->nullable();
            $table->string('payment_info')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->integer('purchase_for')->nullable()->comment('For promote ads identify');
            $table->string('payment_status', 10)->default('pending')->comment('pending,process,complete');
            $table->string('order_status', 10)->default('pending')->comment('pending,process,reject');
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
        Schema::dropIfExists('package_purchases');
    }
}

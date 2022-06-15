<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('amount',11);
            $table->string('currency', 8)->nullable();
            $table->string('currency_symble', 8)->nullable();
            $table->string('payment_method', 25)->nullable();
            $table->string('payment_info', 255)->nullable();
            $table->string('tnx_id', 25)->nullable();
            $table->string('notes')->nullable();
            $table->string('payment_status', 8)->default('pending');
            $table->string('status', 8)->default('pending');
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
        Schema::dropIfExists('deposits');
    }
};

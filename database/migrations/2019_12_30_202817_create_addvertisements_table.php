<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addvertisements', function (Blueprint $table) {
            $table->id();
            $table->string('ads_name', 255)->nullable();
            $table->string('adsType', 25)->nullable();
            $table->integer('days')->default(0);
            $table->integer('price')->default(0);
            $table->string('page', 25)->nullable();
            $table->integer('position')->nullable();
            $table->text('redirect_url')->nullable();
            $table->text('clickBtn')->nullable();
            $table->text('image')->nullable();
            $table->text('add_code')->nullable();
            $table->integer('impressions')->default(0);
            $table->integer('views')->default(0);
            $table->string('status', 10)->default('pending');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('addvertisements');
    }
}

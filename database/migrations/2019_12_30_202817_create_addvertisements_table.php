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
            $table->string('adsType', 25);
            $table->string('page', 25);
            $table->string('position', '15');
            $table->text('redirect_url')->nullable();
            $table->text('clickBtn')->nullable();
            $table->text('image')->nullable();
            $table->text('add_code')->nullable();
            $table->integer('impressions')->default(0);
            $table->integer('views')->default(0);
            $table->tinyInteger('status');
             $table->integer('created_by');
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

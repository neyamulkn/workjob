<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->integer('subcategory_id')->nullable();
            $table->string('image', 175)->nullable();
            $table->string('notes', 255)->nullable();
            $table->tinyInteger('popular')->default(0);
            $table->integer('position')->nullable();
            $table->integer('free_ads_limit')->default(0);
            $table->text('safety_tip')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('categories');
    }
}

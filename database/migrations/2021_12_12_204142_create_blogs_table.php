<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('category_id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->longText('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->dateTime('publish_date');
            $table->integer('views');
            $table->string('meta_title', 255)->nullable();
            $table->text('keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('approved')->default(0);
            $table->string('status', 10)->default('active');
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
        Schema::dropIfExists('blogs');
    }
}

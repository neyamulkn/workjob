<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('slug', 125);
            $table->string('ribbon', 255)->nullable();
            $table->string('promote_demo', 255)->nullable();
            $table->string('ribbon_position', 25)->nullable()->comment('left,top,right');
            $table->text('background_color')->nullable();
            $table->text('text_color')->nullable();
            $table->text('border_color')->nullable();
            $table->text('details')->nullable();
            $table->integer('position')->default(999);
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
        Schema::dropIfExists('packages');
    }
}

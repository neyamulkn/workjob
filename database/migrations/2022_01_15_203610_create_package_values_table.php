<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_values', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->string('category_id', 8)->nullable();
            $table->integer('ads');
            $table->decimal('price', 8,2);
            $table->integer('discount')->nullable();
            $table->integer('duration');
            $table->text('details')->nullable();
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('package_values');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->string('id', 15);
            $table->integer('sender_id');
            $table->integer('receiver_id');
            $table->integer('product_id')->nullable();
            $table->integer('block_user')->nullable();
            $table->dateTime('deleted_date_sender')->nullable();
            $table->dateTime('deleted_date_receiver')->nullable();
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
        Schema::dropIfExists('conversations');
    }
}

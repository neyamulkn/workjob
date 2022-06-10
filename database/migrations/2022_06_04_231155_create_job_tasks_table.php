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
        Schema::create('job_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');
            $table->integer('user_id');
            $table->integer('seller_id');
            $table->decimal('amount');
            $table->date('task_date');
            $table->text('work_prove')->nullable();
            $table->text('screenshots')->nullable();
            $table->text('attachment')->nullable();
            $table->text('reject_reason')->nullable();
            $table->string('status', '10')->default('pending');
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
        Schema::dropIfExists('job_tasks');
    }
};

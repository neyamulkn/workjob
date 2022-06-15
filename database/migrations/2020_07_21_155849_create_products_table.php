<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->string('slug');
            $table->text('summery')->nullable();
            $table->integer('category_id');
            $table->integer('subcategory_id')->nullable();
            $table->text('location')->nullable();
            $table->string('thumb_image', 225)->nullable();
            $table->string('type', 10)->comment('buy,sale,rent');
            $table->longText('workstep')->nullable();
            $table->text('workProve')->nullable();
            $table->integer('job_workers_need')->nullable();
            $table->integer('total_cost')->default(0);
            $table->string('per_workers_earn', 10)->nullable();
            $table->integer('work_screenshots')->nullable();
            $table->string('estimated_time', 255)->nullable();
            
            $table->integer('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_image')->nullable();
            $table->text('delete_reason')->nullable();
            $table->text('reject_reason')->nullable();
            $table->string('promote_status', '10')->default('free');
            $table->dateTime('approved')->nullable();
            $table->string('status', '10')->default('pending')->comment('pending,active,reject');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}

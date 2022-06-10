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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('username', 25);
            $table->text('user_dsc')->nullable();
            $table->string('gender' ,6)->nullable();
            $table->string('birthday')->nullable();
            $table->string('blood')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('mobile_verification_token')->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->string('password')->nullable();
            $table->string('temp_password', 15)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();

            $table->decimal('wallet_balance')->default(0.00);
            $table->integer('p_country')->nullable();
            $table->integer('p_region')->nullable();
            $table->integer('p_city')->nullable();
            $table->integer('p_area')->nullable();
            $table->string('p_address')->nullable();
            $table->integer('country')->nullable();
            $table->integer('region')->nullable();
            $table->integer('city')->nullable();
            $table->integer('area')->nullable();
            $table->string('address')->nullable();
            $table->integer('referral_by')->nullable();
            $table->decimal('referral_amount')->default(0);
            $table->integer('total_referral')->default(0);
            $table->string('referral_code', 15)->nullable();
            $table->string('photo', 225)->nullable();
            $table->integer('profession_id')->nullable();
            $table->integer('education_id')->nullable();
            $table->integer('guardian_id')->nullable();
            $table->text('browse_info')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('join_date')->nullable();
            $table->tinyInteger('activation')->default(1);
            $table->timestamp('verify')->nullable();
            $table->string('status', 10)->default(1)->comment('active, pending');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

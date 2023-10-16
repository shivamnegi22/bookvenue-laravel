<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings',function(Blueprint $table){

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('court_id');
            $table->string('slot_time')->nullable();
            $table->string('duration')->nullable();
            $table->string('total_price')->nullable();
            $table->string('date')->nullable();
            $table->string('booked_by')->nullable();
            $table->string('approved')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->string('payment_type')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('facility_id')->references('id')->on('facility');
            $table->foreign('court_id')->references('id')->on('court');
            $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

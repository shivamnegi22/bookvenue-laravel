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
        Schema::create('review',function(Blueprint $table){

            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id');
            $table->longText('description')->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('facility_id')->references('id')->on('facility');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};

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
        Schema::create('facility', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_category_id');
            $table->text('amenities')->nullable();
            $table->string('official_name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('alias')->nullable();
            $table->text('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('featured_image')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->default(true);
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('verified_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('Service_category_id')->references('id')->on('service_category');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility');
    }

    
};

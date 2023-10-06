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
        Schema::create('facility_venue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facility_id');
            $table->unsignedBigInteger('venue_id');
            $table->string('amenities')->nullable();
            $table->string('start_time')->nullable();
            $table->string('close_time')->nullable();
            $table->string('slot_time')->nullable();
            $table->string('slot_price')->nullable();
            $table->string('court_count')->nullable();
            $table->string('status')->default(true);
            $table->string('breaktime_start')->nullable();
            $table->string('breaktime_end')->nullable();
            $table->text('holiday')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_venue');
    }
};

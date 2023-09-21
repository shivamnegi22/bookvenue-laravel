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
            $table->string('facility_type')->nullable();
            $table->string('official_name')->nullable();
            $table->string('alias')->nullable();
            $table->text('address')->nullable();
            $table->text('location')->nullable();
            $table->longText('images')->nullable();
            $table->string('featured_image')->nullable();
            $table->longText('description')->nullable();
            $table->string('status')->default(true);
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
        Schema::dropIfExists('facility');
    }
};

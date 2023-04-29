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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->integer('guest_id');
            $table->string('city');
            $table->string('country_code')->nullable();
            $table->string('country');
            $table->string('capital');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('flag');
            $table->string('weather_name');
            $table->string('temperature');
            $table->string('humidity');
            $table->string('weather_image');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

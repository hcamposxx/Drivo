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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departure_city_id');
            $table->unsignedBigInteger('arrival_city_id');
            $table->unsignedBigInteger('driver_id');
            $table->integer('available_seats');
            $table->integer('behind_available_seats')->default(1);
            $table->time('trip_duration')->default('01:00:00');
            $table->date('departure_date'); 
            $table->time('departure_time');   
            $table->string('car_plate');
            $table->string('pickup_point');
            $table->string('dropoff_point');
            $table->string('phone')->nullable();
            $table->string('car_color')->nullable();
            $table->decimal('price_per_seat',10,2);
            $table->boolean('smoking_allowed')->default(false);
            $table->boolean('pets_allowed')->default(false); 
            $table->boolean('automatic_reservation')->default(true);
            $table->boolean('active')->default(true);
            $table->string('car_brand');  
            $table->text('details');  
            $table->timestamps();

            $table->foreign('departure_city_id')->references('id')->on('cities');
            $table->foreign('arrival_city_id')->references('id')->on('cities');
            $table->foreign('driver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};

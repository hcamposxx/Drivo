<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_city_id');
            $table->unsignedBigInteger('destination_city_id');
            $table->timestamps();

            $table->foreign('origin_city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('destination_city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->unique(['origin_city_id','destination_city_id']);

            $table->index(['origin_city_id','destination_city_id']);
        });

        DB::statement('ALTER TABLE city_routes ADD CHECK(origin_city_id <> destination_city_id)');

        $cities = City::all();
        foreach ($cities as $originCity) {
            foreach ($cities as $destinationCity) {
                if($originCity-> id !== $destinationCity->id){
                    DB::table('city_routes')->insert([
                        'origin_city_id'=> $originCity->id,
                        'destination_city_id'=> $destinationCity->id,
                        'created_at'=> now(),
                        'updated_at'=> now()
                    ]);

                }
            }    
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_routes');
    }
};

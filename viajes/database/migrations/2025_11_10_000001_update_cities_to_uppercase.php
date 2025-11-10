<?php

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
        // Convertir todos los nombres de ciudades a mayúsculas
        $cities = DB::table('cities')->get();
        
        foreach ($cities as $city) {
            DB::table('cities')
                ->where('id', $city->id)
                ->update([
                    'name' => strtoupper($city->name),
                    'short_name' => strtoupper($city->short_name)
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario revertir esta migración ya que no modifica la estructura
    }
};
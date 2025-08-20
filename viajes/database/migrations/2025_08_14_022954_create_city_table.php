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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("short_name")->unique();
            $table->boolean("active")->default(1);
            $table->timestamps();
        });

        $cities=['Temuco','Villarrica','Pucon','Curarrehue','Caburgua','Freire','Pitrufquen'];
        $cities_short=['TMCO', 'VRRCA','PCN','CRRHUE','CBG','FRE','PTFQN'];

        $citiesData= array_combine($cities,$cities_short);

        foreach ($citiesData as $name=>$shortName){
            DB::table('cities')->insert(['name'=> strtoupper($name),'short_name'=> strtoupper($shortName)]);

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};

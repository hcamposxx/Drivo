<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('admin')->default(false);
            $table->boolean('verified')->default(false);
            $table->boolean('active')->default(true);
            $table->longText('photo')->nullable();
            $table->string('phone')->nullable();
            $table->longText('dni_front')->nullable();
            $table->longText('dni_back')->nullable();
            $table->string('external_id')->nullable();
            $table->string('external_auth')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->float('rating')->default(4.9);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table("users")->insert([
            'name'=>"Administrador",
            'email'=>"admin@example.com",
            'password'=>Hash::make('adminpassword'),
            'admin'=>true,
            'verified'=>true,
            'photo'=>null,
            'phone'=>"123",
            'email_verified_at'=>now(),
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        DB::table("users")->insert([
            'name'=>"Regular User",
            'email'=>"user@example.com",
            'password'=>Hash::make('userpassword'),
            'admin'=>false,
            'verified'=>true,
            'photo'=>null,
            'phone'=>"321",
            'email_verified_at'=>now(),
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

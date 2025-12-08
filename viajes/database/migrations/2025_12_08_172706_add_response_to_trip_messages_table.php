<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trip_messages', function (Blueprint $table) {
            $table->text('response')->nullable()->after('message');
            $table->timestamp('response_date')->nullable()->after('response');
            $table->boolean('response_read')->default(false)->after('response_date');
        });
    }

    public function down(): void
    {
        Schema::table('trip_messages', function (Blueprint $table) {
            $table->dropColumn(['response', 'response_date', 'response_read']);
        });
    }
};
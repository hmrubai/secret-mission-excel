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
        Schema::create('work_calendars', function (Blueprint $table) {
            $table->id();
            // Weekend days stored as JSON [0–6]
            $table->json('weekends'); 
            // Example: [5,6] = Fri,Sat | [0] = Sunday | [6] = Saturday
            $table->time('work_start_time')->default('09:00');
            $table->time('work_end_time')->default('18:00');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_calendars');
    }
};

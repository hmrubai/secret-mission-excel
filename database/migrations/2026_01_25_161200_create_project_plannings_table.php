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
        Schema::create('project_plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('planning_type_id')->constrained('planning_types')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration_days')->nullable(); // calculated (excluding weekends/holidays)
            $table->boolean('exclude_weekends')->default(true);
            $table->boolean('exclude_holidays')->default(true);
            $table->integer('progress')->default(0); // 0–100
            $table->enum('status', ['pending', 'running', 'completed', 'on_hold'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_plannings');
    }
};

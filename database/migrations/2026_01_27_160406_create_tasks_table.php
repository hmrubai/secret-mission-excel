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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('project_module_id')->nullable()->constrained('project_modules')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['draft','pending','in_progress','in_review','completed','blocked'])->default('pending');
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->enum('priority', ["High", "Medium", "Low"])->default("Low"); // 1=High,2=Medium,3=Low
            $table->unsignedTinyInteger('progress')->default(0); // 0–100
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

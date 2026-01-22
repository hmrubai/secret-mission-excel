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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('onhold_postponed_date')->nullable();
            $table->unsignedTinyInteger('progress')->default(0)->comment('0 to 100');
            $table->foreignId('project_type_id')->constrained('project_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'on_hold', 'cancelled'])->default('pending');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name', 80);
            $table->string('code', 20)->unique();
            $table->string('category', 50);
            $table->string('teacher', 100);
            $table->text('description')->nullable();
            $table->string('level', 30)->nullable();

            // Schedule
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('duration')->nullable();   // hours
            $table->unsignedInteger('max_students')->nullable();
            $table->string('time_start', 10)->nullable();
            $table->string('time_end', 10)->nullable();
            $table->string('room', 50)->nullable();
            $table->string('days', 50)->nullable();            // e.g. "ច,ពុ,សុ"

            // Appearance
            $table->string('color', 10)->nullable()->default('#1a237e');
            $table->string('icon', 10)->nullable()->default('💻');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
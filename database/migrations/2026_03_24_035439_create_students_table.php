<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('name_en', 100)->nullable(); // បន្ថែម name_en (សម្រាប់ bilingual)
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();    // បន្ថែម phone (ដើម្បីបាត់ Error)
            $table->unsignedTinyInteger('age')->nullable();
            $table->date('date_of_birth');
            $table->decimal('score', 5, 2);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
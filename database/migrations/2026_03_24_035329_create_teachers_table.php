<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// database/migrations/xxxx_xx_xx_xxxxxx_create_teachers_table.php

// database/migrations/xxxx_xx_xx_xxxxxx_create_teachers_table.php

public function up(): void
{
    Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('name_en')->nullable();
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('gender')->default('Other');
        $table->string('subject')->nullable(); // <--- បន្ថែមបន្ទាត់នេះសម្រាប់ដោះស្រាយ Error ថ្មី
        $table->date('date_of_birth')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // បន្ថែម columns ដែលខ្វះ
            if (!Schema::hasColumn('courses', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('courses', 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn('courses', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('courses', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['image', 'price']);
        });
    }
};
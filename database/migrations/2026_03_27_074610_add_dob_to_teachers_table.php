<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (!Schema::hasColumn('teachers', 'age')) {
                $table->integer('age')->nullable()->after('email');
            }
            if (!Schema::hasColumn('teachers', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('age');
            }
            if (!Schema::hasColumn('teachers', 'gender')) {
                $table->string('gender')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('teachers', 'subject')) {
                $table->string('subject')->nullable()->after('gender');
            }
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['age', 'date_of_birth', 'gender', 'subject']);
        });
    }
};

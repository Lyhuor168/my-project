<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('qty')->default(0)->after('price');
            $table->string('img', 100)->nullable()->after('qty');
            $table->tinyInteger('status')->default(1)->after('img');
        });
    }
    public function down(): void {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['qty', 'img', 'status']);
        });
    }
};

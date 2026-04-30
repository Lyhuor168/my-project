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
        Schema::create('tbl_category', function (Blueprint $table) {
    $table->id(); // int, primary key, auto-increment
    $table->string('name', 255);
    $table->string('img', 255)->nullable();
    $table->integer('status')->default(1);
    $table->timestamp('created')->useCurrent(); 
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

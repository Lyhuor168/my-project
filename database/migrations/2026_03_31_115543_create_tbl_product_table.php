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
      Schema::create('tbl_product', function (Blueprint $table) {
    $table->id();
    $table->string('name', 255);
    $table->integer('price');
    $table->integer('qty');
    $table->integer('cat_id');
    $table->string('img', 255)->nullable();
    $table->integer('status');
    $table->timestamp('created')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_product');
    }
};

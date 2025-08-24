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
        Schema::create('tyre_on_ozon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tyre_id')
                ->constrained('tyres')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('ozon_product_id');
            $table->string('sku')->nullable();
            $table->string('article')->nullable();
            $table->timestamp('picture_upload_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tyre_on_ozon');
    }
};

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
        Schema::create('tyre_model_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')
                ->constrained('tyre_models')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->json('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tyre_model_ratings');
    }
};

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
        Schema::create('tyres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')
                ->constrained('tyre_models', 'id');
            $table->string('slug', 512);
            $table->string('article', 64);
            $table->string('title');
            $table->float('diameter')
                ->nullable();
            $table->float('width')
                ->nullable();
            $table->float('height')
                ->nullable();
            $table->string('season', 16);
            $table->string('load_index', 16)
                ->nullable();
            $table->string('speed_index', 4)
                ->nullable();
            $table->boolean('is_extra_load')
                ->default(false);
            $table->boolean('is_run_flat')
                ->default(false);
            $table->boolean('is_stud')
                ->default(false);
            $table->boolean('is_active')
                ->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tyres');
    }
};

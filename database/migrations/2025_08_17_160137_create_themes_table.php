<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Services\UseCases\Commands\Tyres\Images\Themes\Dark\DarkTheme;
use App\Services\UseCases\Commands\Tyres\Images\Themes\Winter\WinterTheme;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->boolean('current')->default(false);
        });

        DB::table('themes')->insert(['theme' => DarkTheme::class, 'current' => true]);
        DB::table('themes')->insert(['theme' => WinterTheme::class]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Application;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Menjanje enum vrednosti
            $table->enum('status', Application::$statuses)
                  ->default('pending')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Vraćanje na prethodni enum (originalne vrednosti)
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending')
                  ->change();
        });
    }
};
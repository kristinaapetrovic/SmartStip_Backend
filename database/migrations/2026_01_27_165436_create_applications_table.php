<?php

use App\Models\Application;
use App\Models\ScholarshipCall;
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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->enum('status', Application::$statuses)->default('pending');
            $table->string('average_grade_url');
            $table->string('espb_url');
            $table->string('identification_card_url');
            $table->string('proof_of_unenrollment_url');
            $table->foreignIdFor('student')->constrained()->onDelete('cascade');
            $table->foreignIdFor(ScholarshipCall::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

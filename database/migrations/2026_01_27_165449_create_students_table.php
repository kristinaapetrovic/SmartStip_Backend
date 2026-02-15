<?php

use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Location;
use App\Models\Faculty;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('year_of_study');
            $table->enum('type_of_study', Student::$types_of_study);
            $table->double('average_grade');
            $table->string('field_of_study');
            $table->string('index_number')->unique();
            $table->string('street_address');
            $table->string('phone_number');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Location::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Faculty::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

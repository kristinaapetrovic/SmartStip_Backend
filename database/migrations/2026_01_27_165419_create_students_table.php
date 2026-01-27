<?php

use App\Models\Student;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('year_of_study');
            $table->enum('type_of_study', Student::$types_of_study);
            $table->double('average_grade');
            $table->string('field_of_study');
            $table->string('index_number')->unique();
            $table->string('street_address');
            $table->string('phone_number');
            $table->foreignIdFor('user')->constrained()->onDelete('cascade');
            $table->foreignIdFor('location')->constrained()->onDelete('cascade');
            $table->foreignIdFor('faculty')->constrained()->onDelete('cascade');
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

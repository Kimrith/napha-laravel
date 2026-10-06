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
        Schema::create('students', function (Blueprint $table): void {
            $table->id();
            $table->string('student_id', 30)->unique();
            $table->string('name');
            $table->string('gender', 20)->default('Other');
            $table->string('pronouns', 30)->nullable();
            $table->string('dob', 50)->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 50)->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('major');
            $table->string('degree')->nullable();
            $table->decimal('gpa', 3, 2)->default(0.00);
            $table->unsignedSmallInteger('credits')->default(0);
            $table->string('advisor')->nullable();
            $table->string('status', 30)->default('Active');
            $table->string('avatar')->nullable();
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

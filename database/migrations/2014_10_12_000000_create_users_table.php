<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->boolean('is_active')->default(false);
            $table->integer('vacation_days')->default(0); 
            $table->string('employee_no')->default("0");
            $table->string('department_id')->nullable(); 
            $table->date('join_date')->nullable(); 
            $table->enum('role', ['admin', 'employee', 'hr', 'techlead'])->default('employee');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

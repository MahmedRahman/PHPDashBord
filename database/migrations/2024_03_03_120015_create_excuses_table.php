<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('excuses', function (Blueprint $table) {
            $table->id();

            $table->date('create_date')->default(DB::raw('CURRENT_DATE'));

            $table->string('stating')->nullable();

            $table->string('ending')->nullable(); 

            $table->enum('state', ['approval', 'rejection','wait_for_reply'])->default('wait_for_reply');

            $table->string('user_id')->nullable();

            $table->string('comments')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excuses');
    }
};

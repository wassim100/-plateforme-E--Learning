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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->integer('score');
            $table->decimal('percentage', 5, 2);
            $table->integer('time_taken')->nullable();
            $table->json('answers');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at');
            $table->timestamps();

            // Un utilisateur ne peut pas avoir plusieurs résultats en cours pour le même quiz
            $table->unique(['user_id', 'quiz_id', 'completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};

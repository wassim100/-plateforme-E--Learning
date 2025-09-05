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
        Schema::table('questions', function (Blueprint $table) {
            // Ajouter les nouveaux champs s'ils n'existent pas déjà
            if (!Schema::hasColumn('questions', 'type')) {
                $table->string('type')->after('quiz_id')->default('multiple_choice');
            }
            if (!Schema::hasColumn('questions', 'question_text')) {
                $table->text('question_text')->after('type');
            }
            if (!Schema::hasColumn('questions', 'answers')) {
                $table->json('answers')->nullable()->after('question_text');
            }
            if (!Schema::hasColumn('questions', 'correct_answer')) {
                $table->text('correct_answer')->after('answers');
            }
            if (!Schema::hasColumn('questions', 'explanation')) {
                $table->text('explanation')->nullable()->after('correct_answer');
            }
            if (!Schema::hasColumn('questions', 'category')) {
                $table->string('category')->nullable()->after('explanation');
            }
            if (!Schema::hasColumn('questions', 'points')) {
                $table->integer('points')->default(1)->after('category');
            }
            if (!Schema::hasColumn('questions', 'image')) {
                $table->string('image')->nullable()->after('points');
            }

            // Supprimer l'ancien champ text s'il existe
            if (Schema::hasColumn('questions', 'text')) {
                $table->dropColumn('text');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Restaurer l'ancien champ
            $table->text('text');

            // Supprimer les nouveaux champs
            $table->dropColumn([
                'type',
                'question_text',
                'answers',
                'correct_answer',
                'explanation',
                'category',
                'points',
                'image'
            ]);
        });
    }
};

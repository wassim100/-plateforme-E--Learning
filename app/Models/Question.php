<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'type',
        'question_text',
        'answers',
        'correct_answer',
        'explanation',
        'category',
        'points',
        'image'
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Validation des réponses selon le type de question
    public function validateAnswer($answer)
    {
        switch ($this->type) {
            case 'multiple_choice':
                return isset($this->answers[$answer]) && 
                       $this->answers[$answer] === $this->correct_answer;
            
            case 'true_false':
                return $answer === $this->correct_answer;
            
            case 'short_answer':
                return $this->compareShortAnswer($answer);
            
            default:
                return false;
        }
    }

    // Méthode privée pour comparer les réponses courtes
    protected function compareShortAnswer($answer)
    {
        $givenAnswer = strtolower(trim($answer));
        $correctAnswer = strtolower(trim($this->correct_answer));
        return $givenAnswer === $correctAnswer;
    }

    // Statistiques sur la question
    public function getErrorRateAttribute()
    {
        $results = QuizResult::whereJsonContains('answers', ['question_id' => $this->id])->get();
        
        if ($results->isEmpty()) {
            return 0;
        }

        $incorrectCount = $results->filter(function ($result) {
            $answer = collect($result->answers)->firstWhere('question_id', $this->id);
            return $answer && !$answer['is_correct'];
        })->count();

        return ($incorrectCount / $results->count()) * 100;
    }
}

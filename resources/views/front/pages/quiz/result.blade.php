@extends('front.layouts.front')
@section('title', 'Résultat du Quiz - ' . $quiz->title)
@section('content')

<section class="quiz-result">
    <div class="result-header">
        <div class="container">
            <div class="result-card">
                <div class="score-display">
                    <div class="score-circle {{ $result->percentage >= 70 ? 'success' : 'fail' }}">
                        <span class="percentage">{{ number_format($result->percentage, 1) }}%</span>
                        <span class="score-text">{{ $result->score }}/{{ count($result->answers) }}</span>
                    </div>
                </div>
                
                <div class="result-info">
                    <h1>{{ $result->percentage >= 70 ? 'Félicitations !' : 'Continuez vos efforts !' }}</h1>
                    <h2>{{ $quiz->title }}</h2>
                    <p class="course-name">{{ $quiz->course->title }}</p>
                    
                    <div class="result-stats">
                        <div class="stat">
                            <i class="fas fa-clock"></i>
                            <span>Temps: {{ $result->time_taken ?? 'N/A' }}min</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $result->completed_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($result->percentage >= 70)
                        <div class="stat success">
                            <i class="fas fa-check-circle"></i>
                            <span>Quiz réussi</span>
                        </div>
                        @else
                        <div class="stat fail">
                            <i class="fas fa-times-circle"></i>
                            <span>Quiz non réussi</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="result-details">
    <div class="container">
        <div class="box-container">
            <!-- Analyse des réponses -->
            <div class="box">
                <h3 class="title">Analyse de vos réponses</h3>
                <div class="analysis-stats">
                    <div class="analysis-item correct">
                        <i class="fas fa-check"></i>
                        <div>
                            <h4>{{ $correctAnswers }}</h4>
                            <p>Bonnes réponses</p>
                        </div>
                    </div>
                    <div class="analysis-item incorrect">
                        <i class="fas fa-times"></i>
                        <div>
                            <h4>{{ count($result->answers) - $correctAnswers }}</h4>
                            <p>Mauvaises réponses</p>
                        </div>
                    </div>
                    <div class="analysis-item accuracy">
                        <i class="fas fa-target"></i>
                        <div>
                            <h4>{{ number_format($result->percentage, 1) }}%</h4>
                            <p>Précision</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progression et recommandations -->
            <div class="box">
                <h3 class="title">Recommandations</h3>
                <div class="recommendations">
                    @if($result->percentage >= 90)
                        <div class="recommendation excellent">
                            <i class="fas fa-star"></i>
                            <div>
                                <h4>Excellent travail !</h4>
                                <p>Vous maîtrisez parfaitement ce sujet. Continuez sur cette lancée !</p>
                            </div>
                        </div>
                    @elseif($result->percentage >= 70)
                        <div class="recommendation good">
                            <i class="fas fa-thumbs-up"></i>
                            <div>
                                <h4>Bon travail !</h4>
                                <p>Vous avez une bonne compréhension du sujet. Quelques révisions peuvent vous aider à atteindre l'excellence.</p>
                            </div>
                        </div>
                    @else
                        <div class="recommendation improve">
                            <i class="fas fa-book"></i>
                            <div>
                                <h4>À améliorer</h4>
                                <p>Il serait bénéfique de réviser ce chapitre. Consultez les ressources du cours et tentez à nouveau le quiz.</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($canRetake)
                <div class="retake-info">
                    <p>Vous pouvez reprendre ce quiz pour améliorer votre score.</p>
                    <p><strong>Tentatives restantes:</strong> {{ $remainingAttempts ?? 'Illimité' }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Détails des questions (optionnel) -->
<section class="question-review">
    <div class="container">
        <div class="box">
            <div class="review-header">
                <h3 class="title">Révision des questions</h3>
                <button class="toggle-review btn-secondary" onclick="toggleReview()">
                    <span id="toggle-text">Afficher les détails</span>
                    <i class="fas fa-chevron-down" id="toggle-icon"></i>
                </button>
            </div>
            
            <div id="questions-review" style="display: none;">
                @foreach($quiz->questions as $index => $question)
                @php
                    $userAnswer = $result->answers[$question->id] ?? null;
                    $isCorrect = $userAnswer == $question->correct_answer;
                @endphp
                
                <div class="question-review-item {{ $isCorrect ? 'correct' : 'incorrect' }}">
                    <div class="question-header">
                        <span class="question-number">Question {{ $index + 1 }}</span>
                        <span class="result-icon">
                            @if($isCorrect)
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                        </span>
                    </div>
                    
                    <div class="question-content">
                        <h4>{{ $question->question_text }}</h4>
                        
                        <div class="answers-review">
                            @if($question->type === 'multiple_choice')
                                @foreach($question->answers as $answerIndex => $answer)
                                <div class="answer-option 
                                    {{ $answerIndex == $question->correct_answer ? 'correct-answer' : '' }}
                                    {{ $answerIndex == $userAnswer ? 'user-answer' : '' }}">
                                    <span class="answer-text">{{ $answer }}</span>
                                    @if($answerIndex == $question->correct_answer)
                                        <i class="fas fa-check correct-mark"></i>
                                    @endif
                                    @if($answerIndex == $userAnswer && $answerIndex != $question->correct_answer)
                                        <i class="fas fa-times incorrect-mark"></i>
                                    @endif
                                </div>
                                @endforeach
                            @elseif($question->type === 'true_false')
                                <div class="answer-option {{ $question->correct_answer === 'true' ? 'correct-answer' : '' }} {{ $userAnswer === 'true' ? 'user-answer' : '' }}">
                                    <span class="answer-text">Vrai</span>
                                    @if($question->correct_answer === 'true')
                                        <i class="fas fa-check correct-mark"></i>
                                    @endif
                                    @if($userAnswer === 'true' && $question->correct_answer !== 'true')
                                        <i class="fas fa-times incorrect-mark"></i>
                                    @endif
                                </div>
                                <div class="answer-option {{ $question->correct_answer === 'false' ? 'correct-answer' : '' }} {{ $userAnswer === 'false' ? 'user-answer' : '' }}">
                                    <span class="answer-text">Faux</span>
                                    @if($question->correct_answer === 'false')
                                        <i class="fas fa-check correct-mark"></i>
                                    @endif
                                    @if($userAnswer === 'false' && $question->correct_answer !== 'false')
                                        <i class="fas fa-times incorrect-mark"></i>
                                    @endif
                                </div>
                            @elseif($question->type === 'short_answer')
                                <div class="text-answer">
                                    <p><strong>Votre réponse:</strong> {{ $userAnswer }}</p>
                                    <p><strong>Réponse attendue:</strong> {{ $question->correct_answer }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($question->explanation)
                        <div class="explanation">
                            <h5>Explication:</h5>
                            <p>{{ $question->explanation }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Actions -->
<section class="result-actions">
    <div class="container">
        <div class="actions-container">
            @if($canRetake)
                <a href="{{ route('quiz.show', $quiz) }}" class="btn btn-primary">
                    <i class="fas fa-redo"></i> Reprendre le quiz
                </a>
            @endif
            
            <a href="{{ route('course.show', $quiz->course) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour au cours
            </a>
            
            <button onclick="window.print()" class="btn btn-outline">
                <i class="fas fa-print"></i> Imprimer le résultat
            </button>
            
            <button onclick="shareResult()" class="btn btn-outline">
                <i class="fas fa-share"></i> Partager
            </button>
        </div>
    </div>
</section>

<style>
.result-header {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-dark));
    color: var(--white);
    padding: 4rem 0;
    text-align: center;
}

.result-card {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4rem;
    max-width: 80rem;
    margin: 0 auto;
}

.score-circle {
    width: 15rem;
    height: 15rem;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 8px solid var(--white);
    position: relative;
}

.score-circle.success {
    background: var(--green);
}

.score-circle.fail {
    background: var(--red);
}

.percentage {
    font-size: 3.5rem;
    font-weight: bold;
    color: var(--white);
}

.score-text {
    font-size: 1.6rem;
    color: var(--white);
    opacity: 0.9;
}

.result-info {
    text-align: left;
}

.result-info h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: var(--white);
}

.result-info h2 {
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
    color: var(--white);
    opacity: 0.9;
}

.course-name {
    font-size: 1.6rem;
    color: var(--white);
    opacity: 0.8;
    margin-bottom: 2rem;
}

.result-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: rgba(255,255,255,0.1);
    border-radius: 2rem;
    color: var(--white);
}

.stat.success {
    background: rgba(0,255,0,0.2);
}

.stat.fail {
    background: rgba(255,0,0,0.2);
}

.analysis-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.analysis-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 2rem;
    border-radius: 1rem;
    text-align: center;
}

.analysis-item.correct {
    background: rgba(0,255,0,0.1);
    color: var(--green);
}

.analysis-item.incorrect {
    background: rgba(255,0,0,0.1);
    color: var(--red);
}

.analysis-item.accuracy {
    background: rgba(var(--main-color-rgb),0.1);
    color: var(--main-color);
}

.analysis-item i {
    font-size: 3rem;
}

.analysis-item h4 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.recommendations {
    margin: 2rem 0;
}

.recommendation {
    display: flex;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
    border-radius: 1rem;
    margin: 1rem 0;
}

.recommendation.excellent {
    background: rgba(255,215,0,0.1);
    color: var(--orange);
}

.recommendation.good {
    background: rgba(0,255,0,0.1);
    color: var(--green);
}

.recommendation.improve {
    background: rgba(var(--main-color-rgb),0.1);
    color: var(--main-color);
}

.recommendation i {
    font-size: 3rem;
}

.retake-info {
    background: var(--light-bg);
    padding: 2rem;
    border-radius: 1rem;
    margin-top: 2rem;
    text-align: center;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.toggle-review {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.question-review-item {
    margin: 2rem 0;
    padding: 2rem;
    border-radius: 1rem;
    border-left: 4px solid var(--light-color);
}

.question-review-item.correct {
    border-left-color: var(--green);
    background: rgba(0,255,0,0.05);
}

.question-review-item.incorrect {
    border-left-color: var(--red);
    background: rgba(255,0,0,0.05);
}

.question-review-item .question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.question-number {
    font-weight: bold;
    color: var(--main-color);
}

.result-icon i {
    font-size: 2rem;
}

.result-icon .fa-check-circle {
    color: var(--green);
}

.result-icon .fa-times-circle {
    color: var(--red);
}

.answers-review {
    margin: 1.5rem 0;
}

.answer-option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    margin: 0.5rem 0;
    border-radius: 0.5rem;
    background: var(--light-bg);
}

.answer-option.correct-answer {
    background: rgba(0,255,0,0.1);
    border: 2px solid var(--green);
}

.answer-option.user-answer:not(.correct-answer) {
    background: rgba(255,0,0,0.1);
    border: 2px solid var(--red);
}

.correct-mark {
    color: var(--green);
}

.incorrect-mark {
    color: var(--red);
}

.text-answer {
    background: var(--light-bg);
    padding: 1.5rem;
    border-radius: 0.5rem;
}

.explanation {
    background: rgba(var(--main-color-rgb),0.1);
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-top: 1rem;
}

.explanation h5 {
    color: var(--main-color);
    margin-bottom: 1rem;
}

.actions-container {
    display: flex;
    gap: 2rem;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    padding: 3rem 0;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--main-color);
    color: var(--main-color);
}

.btn-outline:hover {
    background: var(--main-color);
    color: var(--white);
}

@media (max-width: 768px) {
    .result-card {
        flex-direction: column;
        gap: 2rem;
    }
    
    .result-info {
        text-align: center;
    }
    
    .result-stats {
        justify-content: center;
    }
    
    .analysis-stats {
        grid-template-columns: 1fr;
    }
    
    .actions-container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .actions-container .btn {
        width: 100%;
        text-align: center;
    }
}

@media print {
    .result-actions, .toggle-review {
        display: none;
    }
}
</style>

<script>
function toggleReview() {
    const reviewSection = document.getElementById('questions-review');
    const toggleText = document.getElementById('toggle-text');
    const toggleIcon = document.getElementById('toggle-icon');
    
    if (reviewSection.style.display === 'none') {
        reviewSection.style.display = 'block';
        toggleText.textContent = 'Masquer les détails';
        toggleIcon.classList.remove('fa-chevron-down');
        toggleIcon.classList.add('fa-chevron-up');
    } else {
        reviewSection.style.display = 'none';
        toggleText.textContent = 'Afficher les détails';
        toggleIcon.classList.remove('fa-chevron-up');
        toggleIcon.classList.add('fa-chevron-down');
    }
}

function shareResult() {
    if (navigator.share) {
        navigator.share({
            title: 'Mon résultat de quiz',
            text: `J'ai obtenu {{ number_format($result->percentage, 1) }}% au quiz "{{ $quiz->title }}"`,
            url: window.location.href
        });
    } else {
        // Fallback pour les navigateurs sans support
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent(`J'ai obtenu {{ number_format($result->percentage, 1) }}% au quiz "{{ $quiz->title }}"`);
        window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
    }
}
</script>

@endsection

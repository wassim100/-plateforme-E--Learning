@extends('front.layouts.front')
@section('title', $quiz->title)
@section('content')

<section class="quiz-header">
    <div class="box-container">
        <div class="box">
            <h1 class="heading">{{ $quiz->title }}</h1>
            <div class="course-info">
                <h3>{{ $quiz->course->title }}</h3>
                <p>{{ $quiz->description }}</p>
            </div>
        </div>
    </div>
</section>

<section class="quiz-info">
    <div class="box-container">
        <div class="box">
            <h3 class="title">Informations du Quiz</h3>
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-question-circle"></i>
                    <h4>{{ $quiz->questions->count() }}</h4>
                    <p>Questions</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <h4>{{ $quiz->duration }}</h4>
                    <p>Minutes</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-redo"></i>
                    <h4>{{ $quiz->max_attempts ?? '∞' }}</h4>
                    <p>Tentatives max</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-trophy"></i>
                    <h4>{{ $quiz->pass_score ?? '70' }}%</h4>
                    <p>Score requis</p>
                </div>
            </div>
        </div>

        @if($userAttempts > 0)
        <div class="box">
            <h3 class="title">Vos tentatives précédentes</h3>
            @foreach($previousResults as $result)
            <div class="result-item">
                <div class="result-info">
                    <span class="score {{ $result->percentage >= 70 ? 'success' : 'fail' }}">
                        {{ number_format($result->percentage, 1) }}%
                    </span>
                    <div class="details">
                        <p>Score: {{ $result->score }}/{{ count($result->answers) }}</p>
                        <small>{{ $result->completed_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<section class="quiz-instructions">
    <div class="box-container">
        <div class="box">
            <h3 class="title">Instructions</h3>
            <div class="instructions-list">
                <ul>
                    <li><i class="fas fa-check"></i> Lisez attentivement chaque question avant de répondre</li>
                    <li><i class="fas fa-check"></i> Vous avez {{ $quiz->duration }} minutes pour terminer le quiz</li>
                    <li><i class="fas fa-check"></i> Une seule réponse est correcte par question</li>
                    @if($quiz->max_attempts)
                    <li><i class="fas fa-check"></i> Vous avez droit à {{ $quiz->max_attempts }} tentative(s) maximum</li>
                    @endif
                    <li><i class="fas fa-check"></i> Votre progression sera sauvegardée automatiquement</li>
                    <li><i class="fas fa-check"></i> Vous devez obtenir au minimum {{ $quiz->pass_score ?? '70' }}% pour réussir</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="quiz-actions">
    <div class="box-container">
        <div class="box">
            @if($canAttempt)
                <div class="action-buttons">
                    <a href="{{ route('quiz.take', $quiz) }}" class="btn">
                        <i class="fas fa-play"></i> Commencer le Quiz
                    </a>
                    <a href="{{ route('course.show', $quiz->course) }}" class="option-btn">
                        <i class="fas fa-arrow-left"></i> Retour au cours
                    </a>
                </div>
            @else
                <div class="restriction-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Tentatives épuisées</h3>
                    <p>Vous avez utilisé toutes vos tentatives pour ce quiz ({{ $quiz->max_attempts }}/{{ $quiz->max_attempts }}).</p>
                    <a href="{{ route('course.show', $quiz->course) }}" class="option-btn">
                        <i class="fas fa-arrow-left"></i> Retour au cours
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
.quiz-header {
    background: linear-gradient(135deg, var(--main-color), var(--main-color-dark));
    color: var(--white);
    padding: 3rem 0;
}

.quiz-header .heading {
    color: var(--white);
    margin-bottom: 2rem;
}

.course-info h3 {
    color: var(--white);
    opacity: 0.9;
    margin-bottom: 1rem;
}

.course-info p {
    color: var(--white);
    opacity: 0.8;
    line-height: 1.6;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.info-item {
    text-align: center;
    padding: 2rem;
    background: var(--light-bg);
    border-radius: .8rem;
    transition: transform 0.3s ease;
}

.info-item:hover {
    transform: translateY(-3px);
}

.info-item i {
    font-size: 3rem;
    color: var(--main-color);
    margin-bottom: 1rem;
}

.info-item h4 {
    font-size: 2.5rem;
    color: var(--black);
    margin-bottom: .5rem;
}

.info-item p {
    color: var(--light-color);
    font-size: 1.4rem;
}

.result-item {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    margin: 1rem 0;
    background: var(--light-bg);
    border-radius: .5rem;
    border-left: 4px solid var(--main-color);
}

.result-info {
    display: flex;
    align-items: center;
    gap: 2rem;
    width: 100%;
}

.score {
    font-size: 2rem;
    font-weight: bold;
    padding: 1rem 1.5rem;
    border-radius: .5rem;
    color: var(--white);
}

.score.success {
    background: var(--main-color);
}

.score.fail {
    background: var(--red);
}

.details p {
    margin-bottom: .5rem;
    color: var(--black);
}

.details small {
    color: var(--light-color);
}

.instructions-list ul {
    list-style: none;
    padding: 0;
}

.instructions-list li {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.5rem 0;
    padding: 1rem;
    background: var(--light-bg);
    border-radius: .5rem;
}

.instructions-list i {
    color: var(--main-color);
    font-size: 1.4rem;
    min-width: 2rem;
}

.action-buttons {
    display: flex;
    gap: 2rem;
    justify-content: center;
    align-items: center;
}

.restriction-message {
    text-align: center;
    padding: 3rem 2rem;
    background: var(--light-bg);
    border-radius: .8rem;
    border-left: 4px solid var(--red);
}

.restriction-message i {
    font-size: 4rem;
    color: var(--red);
    margin-bottom: 2rem;
}

.restriction-message h3 {
    color: var(--red);
    margin-bottom: 1rem;
}

.restriction-message p {
    color: var(--light-color);
    margin-bottom: 2rem;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        gap: 1rem;
    }
    
    .info-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .result-info {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>

@endsection

@extends('front.layouts.front')
@section('title', 'Quiz: ' . $quiz->title)
@section('content')

<section class="quiz-taking">
    <!-- Header avec timer et progression -->
    <div class="quiz-header-fixed">
        <div class="container">
            <div class="quiz-progress-bar">
                <h3>{{ $quiz->title }}</h3>
                <div class="progress-info">
                    <div class="timer" id="timer">
                        <i class="fas fa-clock"></i>
                        <span id="time-display">{{ $quiz->duration }}:00</span>
                    </div>
                    <div class="progress">
                        <span id="current-question">1</span> / {{ $questions->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone du quiz -->
    <div class="quiz-content">
        <form id="quizForm" action="{{ route('quiz.submit', $quiz) }}" method="POST">
            @csrf
            <input type="hidden" id="timeSpent" name="time_spent" value="0">
            
            @foreach($questions as $index => $question)
            <div class="question-slide" data-question="{{ $index + 1 }}" style="{{ $index === 0 ? '' : 'display: none;' }}">
                <div class="question-container">
                    <div class="question-header">
                        <span class="question-number">Question {{ $index + 1 }}</span>
                        <span class="question-type">{{ ucfirst($question->type) }}</span>
                    </div>
                    
                    <div class="question-content">
                        <h3>{{ $question->question_text }}</h3>
                        
                        @if($question->image)
                        <div class="question-image">
                            <img src="{{ asset('storage/' . $question->image) }}" alt="Question image">
                        </div>
                        @endif
                        
                        <div class="answers-container">
                            @if($question->type === 'multiple_choice')
                                @foreach($question->answers as $answerIndex => $answer)
                                <label class="answer-option">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $answerIndex }}"
                                           required>
                                    <span class="answer-text">{{ $answer }}</span>
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                                
                            @elseif($question->type === 'true_false')
                                <label class="answer-option">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="true"
                                           required>
                                    <span class="answer-text">Vrai</span>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="answer-option">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="false"
                                           required>
                                    <span class="answer-text">Faux</span>
                                    <span class="checkmark"></span>
                                </label>
                                
                            @elseif($question->type === 'short_answer')
                                <textarea name="answers[{{ $question->id }}]" 
                                         placeholder="Tapez votre réponse ici..."
                                         required></textarea>
                            @endif
                        </div>
                    </div>
                    
                    <div class="question-navigation">
                        @if($index > 0)
                        <button type="button" class="btn-secondary" onclick="previousQuestion()">
                            <i class="fas fa-arrow-left"></i> Précédent
                        </button>
                        @endif
                        
                        @if($index < $questions->count() - 1)
                        <button type="button" class="btn-primary" onclick="nextQuestion()">
                            Suivant <i class="fas fa-arrow-right"></i>
                        </button>
                        @else
                        <button type="button" class="btn-success" onclick="showSubmitConfirmation()">
                            <i class="fas fa-check"></i> Terminer le quiz
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </form>
    </div>

    <!-- Navigation par questions -->
    <div class="questions-nav">
        <h4>Navigation</h4>
        <div class="questions-grid">
            @foreach($questions as $index => $question)
            <button type="button" 
                    class="question-nav-btn" 
                    data-question="{{ $index + 1 }}"
                    onclick="goToQuestion({{ $index + 1 }})">
                {{ $index + 1 }}
            </button>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal de confirmation -->
<div id="submitModal" class="modal">
    <div class="modal-content">
        <h3>Confirmer la soumission</h3>
        <p>Êtes-vous sûr de vouloir terminer le quiz ? Vous ne pourrez plus modifier vos réponses.</p>
        <div class="modal-actions">
            <button type="button" class="btn-secondary" onclick="closeSubmitModal()">Annuler</button>
            <button type="button" class="btn-primary" onclick="submitQuiz()">Confirmer</button>
        </div>
    </div>
</div>

<!-- Modal de temps écoulé -->
<div id="timeUpModal" class="modal">
    <div class="modal-content">
        <h3>Temps écoulé !</h3>
        <p>Le temps imparti pour ce quiz est terminé. Vos réponses vont être soumises automatiquement.</p>
        <div class="modal-actions">
            <button type="button" class="btn-primary" onclick="submitQuiz()">OK</button>
        </div>
    </div>
</div>

<style>
.quiz-header-fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: var(--white);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    padding: 1rem 0;
}

.quiz-progress-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 120rem;
    margin: 0 auto;
    padding: 0 2rem;
}

.quiz-progress-bar h3 {
    color: var(--main-color);
    margin: 0;
}

.progress-info {
    display: flex;
    gap: 3rem;
    align-items: center;
}

.timer {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 2rem;
    background: var(--light-bg);
    border-radius: 2rem;
    color: var(--main-color);
    font-weight: bold;
    font-size: 1.6rem;
}

.timer.warning {
    background: var(--red);
    color: var(--white);
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.progress {
    font-size: 1.6rem;
    color: var(--light-color);
}

.quiz-content {
    margin-top: 10rem;
    max-width: 80rem;
    margin-left: auto;
    margin-right: auto;
    padding: 2rem;
}

.question-container {
    background: var(--white);
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.question-header {
    background: var(--main-color);
    color: var(--white);
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.question-number {
    font-size: 1.8rem;
    font-weight: bold;
}

.question-type {
    font-size: 1.4rem;
    opacity: 0.9;
}

.question-content {
    padding: 3rem;
}

.question-content h3 {
    font-size: 2.2rem;
    color: var(--black);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.question-image {
    text-align: center;
    margin: 2rem 0;
}

.question-image img {
    max-width: 100%;
    height: auto;
    border-radius: .5rem;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.answers-container {
    margin: 3rem 0;
}

.answer-option {
    display: flex;
    align-items: center;
    padding: 2rem;
    margin: 1rem 0;
    background: var(--light-bg);
    border: 2px solid transparent;
    border-radius: .8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.answer-option:hover {
    background: rgba(var(--main-color-rgb), 0.1);
    border-color: var(--main-color);
}

.answer-option input[type="radio"] {
    display: none;
}

.answer-option input[type="radio"]:checked + .answer-text {
    color: var(--main-color);
    font-weight: bold;
}

.answer-option input[type="radio"]:checked ~ .checkmark {
    background: var(--main-color);
    border-color: var(--main-color);
}

.answer-option input[type="radio"]:checked ~ .checkmark::after {
    display: block;
}

.answer-text {
    flex: 1;
    font-size: 1.6rem;
    color: var(--black);
    margin-left: 1rem;
}

.checkmark {
    width: 2rem;
    height: 2rem;
    border: 2px solid var(--light-color);
    border-radius: 50%;
    position: relative;
    transition: all 0.3s ease;
}

.checkmark::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 1rem;
    height: 1rem;
    background: var(--white);
    border-radius: 50%;
    display: none;
}

textarea {
    width: 100%;
    padding: 2rem;
    border: 2px solid var(--light-color);
    border-radius: .8rem;
    font-size: 1.6rem;
    font-family: inherit;
    resize: vertical;
    min-height: 12rem;
}

textarea:focus {
    outline: none;
    border-color: var(--main-color);
}

.question-navigation {
    padding: 2rem 3rem;
    background: var(--light-bg);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-secondary, .btn-primary, .btn-success {
    padding: 1.2rem 2.4rem;
    border: none;
    border-radius: .6rem;
    font-size: 1.6rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: var(--light-color);
    color: var(--white);
}

.btn-primary {
    background: var(--main-color);
    color: var(--white);
}

.btn-success {
    background: var(--green);
    color: var(--white);
}

.btn-secondary:hover, .btn-primary:hover, .btn-success:hover {
    opacity: 0.9;
    transform: translateY(-2px);
}

.questions-nav {
    position: fixed;
    top: 50%;
    right: 2rem;
    transform: translateY(-50%);
    background: var(--white);
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    max-width: 20rem;
}

.questions-nav h4 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: var(--main-color);
}

.questions-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: .5rem;
}

.question-nav-btn {
    width: 3rem;
    height: 3rem;
    border: 2px solid var(--light-color);
    background: var(--white);
    border-radius: .5rem;
    cursor: pointer;
    font-size: 1.4rem;
    transition: all 0.3s ease;
}

.question-nav-btn:hover {
    background: var(--main-color);
    color: var(--white);
    border-color: var(--main-color);
}

.question-nav-btn.current {
    background: var(--main-color);
    color: var(--white);
    border-color: var(--main-color);
}

.question-nav-btn.answered {
    background: var(--green);
    color: var(--white);
    border-color: var(--green);
}

.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: var(--white);
    margin: 15% auto;
    padding: 3rem;
    width: 50rem;
    max-width: 90%;
    border-radius: 1rem;
    text-align: center;
}

.modal-content h3 {
    color: var(--main-color);
    margin-bottom: 2rem;
}

.modal-content p {
    color: var(--light-color);
    margin-bottom: 3rem;
    line-height: 1.6;
}

.modal-actions {
    display: flex;
    gap: 2rem;
    justify-content: center;
}

@media (max-width: 768px) {
    .questions-nav {
        display: none;
    }
    
    .quiz-content {
        margin-top: 12rem;
        padding: 1rem;
    }
    
    .question-content {
        padding: 2rem;
    }
    
    .question-navigation {
        padding: 1.5rem 2rem;
        flex-direction: column;
        gap: 1rem;
    }
    
    .progress-info {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<script>
let currentQuestion = 1;
let totalQuestions = {{ $questions->count() }};
let timeLimit = {{ $quiz->duration * 60 }}; // en secondes
let timeLeft = timeLimit;
let timerInterval;
let startTime = Date.now();

// Démarrer le timer
function startTimer() {
    timerInterval = setInterval(function() {
        timeLeft--;
        updateTimeDisplay();
        
        if (timeLeft <= 300) { // 5 minutes restantes
            document.getElementById('timer').classList.add('warning');
        }
        
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            showTimeUpModal();
        }
    }, 1000);
}

function updateTimeDisplay() {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    document.getElementById('time-display').textContent = 
        String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
}

function nextQuestion() {
    if (currentQuestion < totalQuestions) {
        document.querySelector(`[data-question="${currentQuestion}"]`).style.display = 'none';
        currentQuestion++;
        document.querySelector(`[data-question="${currentQuestion}"]`).style.display = 'block';
        updateProgress();
        updateNavigationButtons();
    }
}

function previousQuestion() {
    if (currentQuestion > 1) {
        document.querySelector(`[data-question="${currentQuestion}"]`).style.display = 'none';
        currentQuestion--;
        document.querySelector(`[data-question="${currentQuestion}"]`).style.display = 'block';
        updateProgress();
        updateNavigationButtons();
    }
}

function goToQuestion(questionNumber) {
    document.querySelector(`[data-question="${currentQuestion}"]`).style.display = 'none';
    currentQuestion = questionNumber;
    document.querySelector(`[data-question="${currentQuestion}"]`).style.display = 'block';
    updateProgress();
    updateNavigationButtons();
}

function updateProgress() {
    document.getElementById('current-question').textContent = currentQuestion;
}

function updateNavigationButtons() {
    // Mettre à jour les boutons de navigation
    document.querySelectorAll('.question-nav-btn').forEach(btn => {
        btn.classList.remove('current');
        if (parseInt(btn.getAttribute('data-question')) === currentQuestion) {
            btn.classList.add('current');
        }
    });
}

function checkAnsweredQuestions() {
    // Marquer les questions répondues
    document.querySelectorAll('.question-nav-btn').forEach(btn => {
        let questionNum = btn.getAttribute('data-question');
        let slide = document.querySelector(`[data-question="${questionNum}"]`);
        let answered = slide.querySelector('input:checked') || 
                      (slide.querySelector('textarea') && slide.querySelector('textarea').value.trim());
        
        if (answered) {
            btn.classList.add('answered');
        } else {
            btn.classList.remove('answered');
        }
    });
}

function showSubmitConfirmation() {
    document.getElementById('submitModal').style.display = 'block';
}

function closeSubmitModal() {
    document.getElementById('submitModal').style.display = 'none';
}

function showTimeUpModal() {
    document.getElementById('timeUpModal').style.display = 'block';
}

function submitQuiz() {
    // Calculer le temps passé
    let timeSpent = Math.round((Date.now() - startTime) / 60000); // en minutes
    document.getElementById('timeSpent').value = timeSpent;
    
    // Soumettre le formulaire
    document.getElementById('quizForm').submit();
}

// Démarrer le timer au chargement
document.addEventListener('DOMContentLoaded', function() {
    startTimer();
    updateNavigationButtons();
    
    // Écouter les changements de réponses
    document.addEventListener('change', checkAnsweredQuestions);
    document.addEventListener('input', checkAnsweredQuestions);
    
    // Sauvegarder automatiquement les réponses
    setInterval(function() {
        // Auto-save logic here if needed
    }, 30000); // toutes les 30 secondes
});

// Empêcher la fermeture accidentelle
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = 'Êtes-vous sûr de vouloir quitter ? Vos réponses pourraient être perdues.';
});
</script>

@endsection

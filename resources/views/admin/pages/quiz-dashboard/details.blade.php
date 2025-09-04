@extends('admin.layouts.admin')
@section('title', 'Détails Quiz - ' . $quiz->title)
@section('content')
<section class="dashboard">
    <div class="flex">
        <h1 class="heading">{{ $quiz->title }}</h1>
        <a href="{{ route('admin.quiz.dashboard') }}" class="option-btn">Retour Dashboard</a>
    </div>

    <!-- Informations du quiz -->
    <div class="box-container">
        <div class="box">
            <h3 class="title">Informations du quiz</h3>
            <div class="details">
                <p><span>Cours :</span> {{ $quiz->course->title }}</p>
                <p><span>Nombre de questions :</span> {{ $quiz->questions->count() }}</p>
                <p><span>Créé le :</span> {{ $quiz->created_at->format('d/m/Y H:i') }}</p>
                <p><span>Durée :</span> {{ $quiz->duration }} minutes</p>
                <p><span>Tentatives max :</span> {{ $quiz->max_attempts ?? 'Illimité' }}</p>
            </div>
        </div>

        <!-- Statistiques du quiz -->
        <div class="box">
            <h3 class="title">Statistiques</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <h4>{{ $stats['total_attempts'] }}</h4>
                    <p>Tentatives</p>
                </div>
                <div class="stat-item">
                    <h4>{{ number_format($stats['average_score'], 1) }}%</h4>
                    <p>Score moyen</p>
                </div>
                <div class="stat-item">
                    <h4>{{ $stats['completion_rate'] }}%</h4>
                    <p>Taux de réussite</p>
                </div>
                <div class="stat-item">
                    <h4>{{ number_format($stats['average_time'], 1) }}min</h4>
                    <p>Temps moyen</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution des scores -->
    <div class="box-container">
        <div class="box">
            <h3 class="title">Distribution des scores</h3>
            <div class="chart-container">
                @foreach($scoreDistribution as $range => $count)
                <div class="score-bar">
                    <span class="range">{{ $range }}</span>
                    <div class="bar">
                        <div class="fill" style="width: {{ $stats['total_attempts'] > 0 ? ($count / $stats['total_attempts']) * 100 : 0 }}%"></div>
                    </div>
                    <span class="count">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Questions les plus difficiles -->
        <div class="box">
            <h3 class="title">Questions les plus difficiles</h3>
            @forelse($difficultQuestions as $question)
            <div class="question-item">
                <p>{{ Str::limit($question->question_text, 80) }}</p>
                <div class="question-stats">
                    <span class="error-rate">{{ number_format($question->error_rate, 1) }}% d'erreurs</span>
                    <span class="attempts">{{ $question->total_attempts }} tentatives</span>
                </div>
            </div>
            @empty
            <p>Aucune donnée disponible.</p>
            @endforelse
        </div>
    </div>

    <!-- Résultats récents -->
    <div class="box-container">
        <div class="box" style="grid-column: 1 / -1;">
            <div class="flex">
                <h3 class="title">Résultats récents</h3>
                <a href="{{ route('admin.quiz.export', $quiz) }}" class="option-btn">Exporter Excel</a>
            </div>
            
            @if($results->count() > 0)
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Score</th>
                            <th>Pourcentage</th>
                            <th>Temps</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <h4>{{ $result->user->name }}</h4>
                                    <p>{{ $result->user->email }}</p>
                                </div>
                            </td>
                            <td>{{ $result->score }}/{{ count($result->answers) }}</td>
                            <td>
                                <span class="score-badge {{ $result->percentage >= 70 ? 'success' : 'fail' }}">
                                    {{ number_format($result->percentage, 1) }}%
                                </span>
                            </td>
                            <td>{{ $result->time_taken ?? 'N/A' }}min</td>
                            <td>{{ $result->completed_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="#" class="inline-option-btn" onclick="viewDetails({{ $result->id }})">Détails</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $results->links() }}
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-clipboard-question"></i>
                <h3>Aucun résultat</h3>
                <p>Ce quiz n'a pas encore été tenté par les étudiants.</p>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Modal pour détails du résultat -->
<div id="resultModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="resultDetails"></div>
    </div>
</div>

<style>
.details p {
    display: flex;
    justify-content: space-between;
    margin: 1rem 0;
    padding: 1rem 0;
    border-bottom: var(--border);
}

.details span {
    font-weight: bold;
    color: var(--main-color);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: var(--light-bg);
    border-radius: .5rem;
}

.stat-item h4 {
    font-size: 2.5rem;
    color: var(--main-color);
    margin-bottom: .5rem;
}

.chart-container {
    margin: 2rem 0;
}

.score-bar {
    display: flex;
    align-items: center;
    margin: 1rem 0;
    gap: 1rem;
}

.score-bar .range {
    min-width: 8rem;
    font-size: 1.4rem;
    color: var(--light-color);
}

.score-bar .bar {
    flex: 1;
    height: 2rem;
    background: var(--light-bg);
    border-radius: 1rem;
    overflow: hidden;
}

.score-bar .fill {
    height: 100%;
    background: var(--main-color);
    transition: width 0.3s ease;
}

.score-bar .count {
    min-width: 3rem;
    text-align: center;
    font-size: 1.4rem;
    color: var(--black);
}

.question-item {
    margin: 1.5rem 0;
    padding: 1.5rem;
    background: var(--light-bg);
    border-radius: .5rem;
}

.question-stats {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.error-rate {
    color: var(--red);
    font-size: 1.2rem;
}

.attempts {
    color: var(--light-color);
    font-size: 1.2rem;
}

.table-responsive {
    overflow-x: auto;
    margin: 2rem 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
}

th, td {
    padding: 1.5rem;
    text-align: left;
    border-bottom: var(--border);
}

th {
    background: var(--light-bg);
    font-weight: bold;
    color: var(--main-color);
}

.user-info h4 {
    margin-bottom: .5rem;
    color: var(--black);
}

.user-info p {
    color: var(--light-color);
    font-size: 1.2rem;
}

.score-badge {
    padding: .5rem 1rem;
    border-radius: .5rem;
    color: var(--white);
    font-weight: bold;
}

.score-badge.success {
    background: var(--main-color);
}

.score-badge.fail {
    background: var(--red);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--light-color);
}

.empty-state i {
    font-size: 5rem;
    margin-bottom: 2rem;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: var(--white);
    margin: 5% auto;
    padding: 2rem;
    width: 80%;
    max-width: 60rem;
    border-radius: .5rem;
    position: relative;
}

.close {
    position: absolute;
    right: 2rem;
    top: 1rem;
    font-size: 3rem;
    cursor: pointer;
    color: var(--light-color);
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
}
</style>

<script>
function viewDetails(resultId) {
    // Ajax call to get result details
    fetch(`/admin/quiz/result/${resultId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('resultDetails').innerHTML = data.html;
            document.getElementById('resultModal').style.display = 'block';
        });
}

// Close modal
document.querySelector('.close').onclick = function() {
    document.getElementById('resultModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('resultModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
@endsection

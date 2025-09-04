@extends('admin.layouts.admin')
@section('title','Dashboard Quiz')
@section('content')
<section class="dashboard">
    <h1 class="heading">Dashboard Quiz</h1>

    <!-- Statistiques générales -->
    <div class="box-container">
        <div class="box">
            <h3>{{ $stats['total_quizzes'] }}</h3>
            <p>Total Quiz</p>
            <i class="fas fa-clipboard-question"></i>
        </div>
        <div class="box">
            <h3>{{ $stats['total_questions'] }}</h3>
            <p>Total Questions</p>
            <i class="fas fa-question-circle"></i>
        </div>
        <div class="box">
            <h3>{{ $stats['total_attempts'] }}</h3>
            <p>Tentatives</p>
            <i class="fas fa-users"></i>
        </div>
        <div class="box">
            <h3>{{ number_format($stats['average_score'], 1) }}%</h3>
            <p>Score Moyen</p>
            <i class="fas fa-chart-line"></i>
        </div>
    </div>

    <!-- Quiz populaires -->
    <div class="box-container">
        <div class="box">
            <h3 class="title">Quiz les plus populaires</h3>
            @forelse($popularQuizzes as $quiz)
                <div class="flex" style="justify-content: space-between; align-items: center; margin: 1rem 0; padding: 1rem; background: var(--light-bg); border-radius: .5rem;">
                    <div>
                        <h4>{{ $quiz->title }}</h4>
                        <p style="color: var(--light-color);">{{ $quiz->course->title }}</p>
                    </div>
                    <div style="text-align: right;">
                        <span class="inline-btn">{{ $quiz->results_count }} tentatives</span>
                        <br>
                        <a href="{{ route('admin.quiz.details', $quiz) }}" class="inline-option-btn" style="margin-top: .5rem;">Détails</a>
                    </div>
                </div>
            @empty
                <p>Aucun quiz disponible.</p>
            @endforelse
        </div>

        <!-- Résultats récents -->
        <div class="box">
            <h3 class="title">Résultats récents</h3>
            @forelse($recentResults as $result)
                <div class="flex" style="justify-content: space-between; align-items: center; margin: 1rem 0; padding: 1rem; background: var(--light-bg); border-radius: .5rem;">
                    <div>
                        <h4>{{ $result->user->name }}</h4>
                        <p style="color: var(--light-color);">{{ $result->quiz->title }}</p>
                        <small>{{ $result->completed_at->diffForHumans() }}</small>
                    </div>
                    <div style="text-align: right;">
                        <span class="inline-btn" style="background: {{ $result->percentage >= 70 ? 'var(--main-color)' : 'var(--red)' }}">
                            {{ number_format($result->percentage, 1) }}%
                        </span>
                        <br>
                        <small>{{ $result->score }}/{{ $result->total_questions }}</small>
                    </div>
                </div>
            @empty
                <p>Aucun résultat disponible.</p>
            @endforelse
        </div>
    </div>

    <!-- Statistiques par cours -->
    @if($courseStats->count() > 0)
    <div class="box-container">
        <div class="box" style="grid-column: 1 / -1;">
            <h3 class="title">Statistiques par cours</h3>
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="padding: 1rem; text-align: left; border-bottom: var(--border);">Cours</th>
                            <th style="padding: 1rem; text-align: center; border-bottom: var(--border);">Quiz</th>
                            <th style="padding: 1rem; text-align: center; border-bottom: var(--border);">Tentatives</th>
                            <th style="padding: 1rem; text-align: center; border-bottom: var(--border);">Score Moyen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courseStats as $stat)
                        <tr>
                            <td style="padding: 1rem; border-bottom: var(--border);">{{ $stat->course_title }}</td>
                            <td style="padding: 1rem; text-align: center; border-bottom: var(--border);">{{ $stat->quiz_count }}</td>
                            <td style="padding: 1rem; text-align: center; border-bottom: var(--border);">{{ $stat->attempt_count }}</td>
                            <td style="padding: 1rem; text-align: center; border-bottom: var(--border);">
                                {{ $stat->avg_score ? number_format($stat->avg_score, 1) . '%' : 'N/A' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions rapides -->
    <div class="box-container">
        <div class="box">
            <a href="{{ route('admin.quizzes.create') }}" class="btn">Créer un nouveau quiz</a>
        </div>
        <div class="box">
            <a href="{{ route('admin.quizzes.index') }}" class="option-btn">Gérer les quiz</a>
        </div>
        <div class="box">
            <a href="{{ route('admin.questions.index') }}" class="option-btn">Gérer les questions</a>
        </div>
    </div>
</section>

<style>
.dashboard .box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.dashboard .box {
    background: var(--white);
    padding: 2rem;
    border-radius: .5rem;
    position: relative;
}

.dashboard .box h3 {
    font-size: 3rem;
    color: var(--main-color);
    margin-bottom: .5rem;
}

.dashboard .box p {
    color: var(--light-color);
    font-size: 1.8rem;
}

.dashboard .box i {
    position: absolute;
    top: 2rem;
    right: 2rem;
    font-size: 3rem;
    color: var(--light-color);
}
</style>
@endsection

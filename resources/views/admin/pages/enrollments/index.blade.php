@extends('admin.layouts.admin')
@section('title','Inscriptions')
@section('content')
<section class="dashboard">
    <h1 class="heading">Inscriptions</h1>

    <div class="box-container">
        <div class="box">
            <a href="{{ route('admin.enrollments.create') }}" class="btn">Inscrire un Étudiant</a>
        </div>
    </div>

    <div class="box-container">
        @forelse ($enrollments as $enrollment)
            <div class="box">
                <div class="flex">
                    <div style="flex: 1;">
                        <p>ID Inscription : <span>{{ $enrollment->id }}</span></p>
                        <p>Étudiant : <span>{{ $enrollment->user->name }} ({{ $enrollment->user->email }})</span></p>
                    </div>
                    <div style="flex: 1;">
                        <p>Cours : <span>{{ $enrollment->course->title }}</span></p>
                        <p>Date : <span>{{ $enrollment->created_at->format('d/m/Y') }}</span></p>
                    </div>
                </div>
                <div class="flex-btn">
                    <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette inscription ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Annuler l'inscription</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="box" style="text-align: center;">
                <p>Aucune inscription trouvée.</p>
            </div>
        @endforelse
    </div>
</section>
@endsectionyouts.admin')
@section('title','Enrollments')
@section('content')
<section class="dashboard">
  <h1 class="heading">Enrollments</h1>
  <div class="card">
    <div class="card-header"><h3>Liste (placeholder)</h3></div>
    <div class="card-body table-wrap">
      <table class="table">
        <thead><tr><th>ID</th><th>Utilisateur</th><th>Cours</th></tr></thead>
        <tbody>
          <tr><td colspan="3">Bientôt: CRUD enrollments ici.</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection

@extends('admin.layouts.admin')
@section('title','Inscriptions')
@section('content')
<section class="courses-table">
    <h1 class="heading">Inscriptions</h1>
        <div class="header-row">
            <div class="header-left">
                <form class="a-search" method="GET" action="{{ route('admin.enrollments.index') }}">
                    <input type="text" name="q" value="{{ request('q','') }}" placeholder="Rechercher par étudiant ou cours">
                    <button type="submit" class="a-btn">Chercher</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.enrollments.index') }}" class="a-btn">Réinitialiser</a>
                    @endif
                </form>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.enrollments.create') }}" class="a-btn a-btn-primary">Inscrire un Étudiant</a>
            </div>
        </div>
        <div class="table-container">
                <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Étudiant</th>
                        <th>Cours</th>
                        <th>Date</th>
                            <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments as $enrollment)
                        <tr>
                            <td>{{ $enrollment->id }}</td>
                            <td>{{ $enrollment->user->name }} ({{ $enrollment->user->email }})</td>
                            <td>{{ $enrollment->course->title }}</td>
                            <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                              <td class="actions">
                                <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" onsubmit="return confirm('Annuler cette inscription ?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                  <button type="submit" class="delete-btn">Annuler</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Aucune inscription trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

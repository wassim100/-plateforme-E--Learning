@extends('admin.layouts.admin')
@section('title','Utilisateurs')
@section('content')
<section class="courses-table">
    <h1 class="heading">Utilisateurs</h1>
    <div class="header-row">
        <div class="header-left">
            <form action="{{ route('admin.users.index') }}" method="GET" class="a-search">
                <input type="text" name="q" value="{{ request('q','') }}" placeholder="Rechercher par nom ou email">
                <button type="submit" class="a-btn">Chercher</button>
                @if(request()->filled('q'))
                    <a href="{{ route('admin.users.index') }}" class="a-btn">Réinitialiser</a>
                @endif
            </form>
        </div>
        <div class="header-right"></div>
    </div>
    @if($users->count() > 0)
    <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td style="text-transform: capitalize;">{{ $user->role }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn">Voir</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="option-btn">Modifier</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
    @else
        <div class="table-container"><div style="padding:1rem;">Aucun utilisateur trouvé.</div></div>
    @endif
</section>
@endsection
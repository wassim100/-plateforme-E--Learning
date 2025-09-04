@extends('admin.layouts.admin')
@section('title','Utilisateurs')
@section('content')
<section class="dashboard admin_user">
    <h1 class="heading">Utilisateurs</h1>

    @if($users->count() > 0)
        <div class="table-container">
            <table class="users-table">
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
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn action_btn_table">Voir</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="option-btn action_btn_table">Modifier</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="action_btn_table"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn ">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>Aucun utilisateur trouvé.</p>
        </div>
    @endif
</section>

<style>

</style>
@endsection
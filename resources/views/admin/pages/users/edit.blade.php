@extends('admin.layouts.admin')
@section('title','Modifier Utilisateur')
@section('content')
<section class="dashboard">
    <h1 class="heading">Modifier l'Utilisateur</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nom *</label>
                    <input type="text" class="box" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="box" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="role">Rôle *</label>
                    <select class="box" id="role" name="role" required>
                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Étudiant</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" class="box" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input type="password" class="box" id="password_confirmation" name="password_confirmation">
                </div>
                <button type="submit" class="btn">Mettre à jour</button>
                <a href="{{ route('admin.users.index') }}" class="option-btn">Annuler</a>
            </form>
        </div>
    </div>
</section>
@endsection

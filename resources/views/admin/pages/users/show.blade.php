@extends('admin.layouts.admin')
@section('title','Détails Utilisateur')
@section('content')
<section class="dashboard">
    <h1 class="heading">Détails de l'Utilisateur</h1>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Nom:</label>
                <p class="box">{{ $user->name }}</p>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <p class="box">{{ $user->email }}</p>
            </div>
            <div class="form-group">
                <label>Rôle:</label>
                <p class="box">{{ ucfirst($user->role) }}</p>
            </div>
            <div class="form-group">
                <label>Créé le:</label>
                <p class="box">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="form-group">
                <label>Mis à jour le:</label>
                <p class="box">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn">Retour à la liste</a>
        </div>
    </div>
</section>
@endsection

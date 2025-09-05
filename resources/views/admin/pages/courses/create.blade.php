@extends('admin.layouts.admin')
@section('title','Ajouter un Cours')
@section('content')
<section class="dashboard">
    <h1 class="heading">Ajouter un Nouveau Cours</h1>
    <div class="card" style="max-width: 720px; margin: 0 auto;">
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="form-vertical">
                @csrf
                <div class="form-group">
                    <label for="title">Nom du cours *</label>
                    <input type="text" class="box" id="title" name="title" placeholder="Ex: Introduction à Python" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="box" id="description" name="description" rows="6" placeholder="Décrivez le contenu et les objectifs du cours" style="resize: vertical; min-height: 120px;"></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Prix</label>
                    <input type="number" class="box" id="price" name="price" step="0.01" placeholder="Ex: 49.99">
                </div>
                <div class="form-group">
                    <label for="category_id">Catégorie *</label>
                    <select class="box" id="category_id" name="category_id" required>
                        <option value="" disabled selected>-- Choisir une catégorie --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Photo</label>
                    <input type="file" class="box" id="image" name="image" accept="image/*">
                </div>
                <div class="form-group actions" style="display:flex; gap:.6rem;">
                    <button type="submit" class="btn" style="flex:1;">Enregistrer</button>
                    <a href="{{ route('admin.courses.index') }}" class="option-btn" style="flex:1; text-align:center;">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

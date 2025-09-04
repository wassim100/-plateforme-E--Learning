@extends('admin.layouts.admin')

@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Cours</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Liste des Cours</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Détails du Cours</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Détails du Cours</h5>
                <hr/>
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Titre:</label>
                            <p>{{ $course->title }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <p>{{ $course->description }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix:</label>
                            <p>{{ $course->price }} €</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catégorie:</label>
                            <p>{{ $course->category->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Créé le:</label>
                            <p>{{ $course->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mis à jour le:</label>
                            <p>{{ $course->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if($course->image)
                            <label class="form-label">Image:</label>
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded">
                        @endif
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>

    </div>
@endsection

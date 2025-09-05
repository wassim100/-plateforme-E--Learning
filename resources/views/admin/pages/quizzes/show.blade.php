@extends('admin.layouts.admin')

@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Quiz</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Liste des Quizzes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Détails du Quiz</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Détails du Quiz</h5>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Titre:</label>
                            <p>{{ $quiz->title }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <p>{{ $quiz->description }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cours Associé:</label>
                            <p>{{ $quiz->course->title }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Créé le:</label>
                            <p>{{ $quiz->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mis à jour le:</label>
                            <p>{{ $quiz->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>

    </div>
@endsection

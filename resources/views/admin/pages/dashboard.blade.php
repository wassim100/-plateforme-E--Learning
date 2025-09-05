@extends('admin.layouts.admin')
@section('title','Dashboard')
@section('content')
<section class="dashboard">
  <h1 class="heading">Tableau de bord</h1>
  <div class="box-container kpis">
    <div class="box"><h3 id="kpi-users">0</h3><p>Utilisateurs</p></div>
    <div class="box"><h3 id="kpi-courses">0</h3><p>Cours</p></div>
    <div class="box"><h3 id="kpi-categories">0</h3><p>Catégories</p></div>
    <div class="box"><h3 id="kpi-enrollments">0</h3><p>Inscriptions</p></div>
    <div class="box"><h3 id="kpi-quizzes">0</h3><p>Quizzes</p></div>
    <div class="box"><h3 id="kpi-questions">0</h3><p>Questions</p></div>
  </div>
  <div class="admin-grid">
    <div class="card"><div class="card-header"><h3>Users by role</h3></div><div class="card-body"><canvas id="rolesChart" height="120"></canvas></div></div>
    <div class="card"><div class="card-header"><h3>Weekly registrations</h3></div><div class="card-body"><canvas id="weeklyChart" height="120"></canvas></div></div>
    <div class="card">
      <div class="card-header"><h3>Derniers utilisateurs</h3></div>
      <div class="card-body table-wrap">
        <table class="table">
          <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th></tr></thead>
          <tbody id="users-tbody"></tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@extends('admin.layouts.admin')
@section('title','Inscription')
@section('content')
<section class="form-container">
    <form method="POST" action="/register">
        <h3>Inscription</h3>
        <?php echo csrf_field(); ?>
        <div class="inputBox">
            <label>Nom</label>
            <input type="text" name="name" required class="box" value="<?php echo e(old('name')); ?>">
        </div>
        <div class="inputBox">
            <label>Email</label>
            <input type="email" name="email" required class="box" value="<?php echo e(old('email')); ?>">
        </div>
        <div class="inputBox">
            <label>Mot de passe</label>
            <input type="password" name="password" required class="box">
        </div>
        <div class="inputBox">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="box"    >
        </div>
        <?php if($errors->any()): ?>
            <div style="color:#b00;margin:8px 0;">
                <?php echo e($errors->first()); ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="inline-btn">Créer le compte</button>
        <p style="margin-top:12px;">Déjà inscrit? <a href="/login">Connexion</a></p>
    </form>
</section>
@endsection


@extends('admin.layouts.admin')
@section('title','Connexion')
@section('content')

<section class="form-container">
    <form method="POST" action="/login">
        <h3>Connexion</h3>
        <?php echo csrf_field(); ?>
        <div class="inputBox">
            <label>Email</label>
            <input type="email" name="email" required class="box" value="<?php echo e(old('email')); ?>">
        </div>
        <div class="inputBox">
            <label>Mot de passe</label>
            <input type="password" name="password" required class="box" >
        </div>
        <div class="flex">
            <label style="display:flex;gap:8px;align-items:center;">
                <input type="checkbox" name="remember" value="1"> Se souvenir de moi
            </label>
        </div>
        <?php if($errors->any()): ?>
            <div style="color:#b00;margin:8px 0;">
                <?php echo e($errors->first()); ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="inline-btn">Se connecter</button>
        <p style="margin-top:12px;">Pas de compte? <a href="/register">Inscription</a></p>
    </form>
    
</section>
@endsection


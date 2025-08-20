<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/desgin/css/style.css">
</head>
<body>
<div class="container" style="max-width:420px;margin:48px auto;padding:24px;border:1px solid #eee;border-radius:8px;">
    <h2>Connexion</h2>
    <form method="POST" action="/login">
        <?php echo csrf_field(); ?>
        <div class="inputBox">
            <label>Email</label>
            <input type="email" name="email" required value="<?php echo e(old('email')); ?>">
        </div>
        <div class="inputBox">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
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
    </form>
    <p style="margin-top:12px;">Pas de compte? <a href="/register">Inscription</a></p>
</div>
</body>
</html>

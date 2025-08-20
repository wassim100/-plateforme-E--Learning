<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="/desgin/css/style.css">
</head>
<body>
<div class="container" style="max-width:480px;margin:48px auto;padding:24px;border:1px solid #eee;border-radius:8px;">
    <h2>Inscription</h2>
    <form method="POST" action="/register">
        <?php echo csrf_field(); ?>
        <div class="inputBox">
            <label>Nom</label>
            <input type="text" name="name" required value="<?php echo e(old('name')); ?>">
        </div>
        <div class="inputBox">
            <label>Email</label>
            <input type="email" name="email" required value="<?php echo e(old('email')); ?>">
        </div>
        <div class="inputBox">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <div class="inputBox">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <?php if($errors->any()): ?>
            <div style="color:#b00;margin:8px 0;">
                <?php echo e($errors->first()); ?>
            </div>
        <?php endif; ?>
        <button type="submit" class="inline-btn">Créer le compte</button>
    </form>
    <p style="margin-top:12px;">Déjà inscrit? <a href="/login">Connexion</a></p>
</div>
</body>
</html>

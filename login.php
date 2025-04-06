<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center mb-4">Connexion</h2>

                
                <?php if (isset($error_msg) && $error_msg): ?>
                    <div class="alert alert-danger" id="error-message">
                        <?= htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                
                <form method="POST" action="src/php/login.php" id="login-form">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>

                
                <div class="text-center mt-3">
                    <p>Vous n'avez pas de compte ? <a href="signup.php" class="text-primary">Inscrivez-vous ici</a>.</p>
                    <p><a href="reset_password_request.php" class="text-danger">Mot de passe oublié ?</a></p>
                </div>
            </div>
        </div>
    </div> 

    <script src="src/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

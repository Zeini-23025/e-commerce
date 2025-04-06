<?php
session_start();
include 'config/db_conn.php';

if (!isset($_SESSION['reset_user_id'])) {
    header("Location: reset_password_request.php");
    exit();
}

$error_msg = '';
$success_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $user_id = $_SESSION['reset_user_id'];

    if ($new_password !== $confirm_password) {
        $error_msg = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 8) {
        $error_msg = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sqlUpdate = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("si", $hashed_password, $user_id);

        if ($stmt->execute()) {
            $success_msg = "Votre mot de passe a été mis à jour avec succès.";
            unset($_SESSION['reset_user_id'], $_SESSION['reset_user_email']);
            header("Location: login.php");
            exit();
        } else {
            $error_msg = "Une erreur est survenue. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <h2 class="text-center mb-4">Réinitialisation du mot de passe</h2>

                
                <?php if (isset($error_msg) && $error_msg): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error_msg) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($success_msg) && $success_msg): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($success_msg) ?>
                    </div>
                <?php endif; ?>

                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmez le mot de passe</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Réinitialiser le mot de passe</button>
                </form>
                <div class="text-center mt-3">
                    <p>Vous avez déjà un compte ? <a href="login.php" class="text-primary">Connectez-vous ici</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

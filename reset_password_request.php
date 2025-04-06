<?php
session_start();
include 'config/db_conn.php';

$error_msg = '';
$success_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['reset_user_id'] = $user['id'];
        $_SESSION['reset_user_email'] = $email;
        $success_msg = "Un lien temporaire a été généré. Accédez à cette page pour réinitialiser votre mot de passe.";
        header("Location: reset_password.php");
        exit();
    } else {
        $error_msg = "Aucun utilisateur trouvé avec cet email.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demander une réinitialisation</title>
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
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
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
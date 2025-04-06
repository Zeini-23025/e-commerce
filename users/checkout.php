<?php
session_start();
if (empty($_SESSION['cart'])) {
    echo "Votre panier est vide.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande - MonApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include "../src/php/user_navbar.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Finaliser la Commande</h1>

        <form action="place_order.php" method="POST">
            <div class="mb-3">
                <label for="address" class="form-label">Adresse de livraison</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Passer la commande</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

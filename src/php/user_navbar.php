<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation - MonApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .cart-badge {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0% { transform: scale(1); }
            30% { transform: scale(1.1); }
            50% { transform: scale(1); }
            70% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MonApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category_page.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="all_products.php">Produits</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">Historique</a>
                    </li>
                    <?php endif ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">
                            <i class="bi bi-cart-fill"></i> Panier
                            <?php
                            $cart_count = 0;
                            if (isset($_SESSION['cart'])) {
                                // Si l'utilisateur est connecté
                                $cart_count = count($_SESSION['cart']);
                            } elseif (isset($_COOKIE['cart'])) {
                                // Si l'utilisateur n'est pas connecté, on récupère les données du cookie
                                $cart = json_decode($_COOKIE['cart'], true);
                                $cart_count = count($cart);
                            }
                            if ($cart_count > 0): ?>
                                <span class="badge bg-danger cart-badge"><?= $cart_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../../src/php/logout.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../../login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../signup.php">Signup</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

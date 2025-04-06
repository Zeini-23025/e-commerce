<?php
session_start();
include 'config/db_conn.php';

// Sélectionner les produits disponibles
$sqlProducts = "SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT 10";
$resultProducts = $conn->query($sqlProducts);

$sqlCategories = "SELECT * FROM category";
$resultCategories = $conn->query($sqlCategories);

// Vérifier si l'utilisateur est connecté
$is_user_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - MonApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

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
                        <a class="nav-link" href="users/index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users/category_page.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users/all_products.php">Produits</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="users/history.php">Historique</a>
                    </li>
                    <?php endif ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="users/panier.php">
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
                            <a class="nav-link" href="src/php/logout.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Signup</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Bienvenue sur MonApp</h1>


    
        <div class="container mt-5">
        <?php if ($resultCategories->num_rows > 0): ?>
            <h3 class="text-center mb-4">Quelques Catégories</h3>
            <div class="row">
                <?php while ($category = $resultCategories->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card category-card p-3 shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($category['description']) ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($category['name']) ?></h5>
                                <a href="users/products_by_category.php?category_id=<?= $category['id'] ?>" class="btn btn-primary mt-2">Voir les produits</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucune catégorie disponible.</p>
        <?php endif; ?>
    </div>


        <?php if ($resultProducts->num_rows > 0): ?>
            <div class="row mt-4">
            <h3 class="text-center mb-4">Quelques produit</h3>
                <?php while ($product = $resultProducts->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if (!empty($product['image']) && file_exists("" . $product['image'])): ?>
                                <img src="<?= $product['image'] ?>" class="card-img-top" alt="Image du produit" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="uploads/default.png" class="card-img-top" alt="Image par défaut" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p class="card-text"><strong>Prix :</strong> <?= number_format($product['price'], 2) ?> €</p>
                                <p class="card-text"><strong>Quantité disponible :</strong> <?= htmlspecialchars($product['quantity']) ?></p>

                                <!-- Formulaire pour ajouter le produit au panier sans champ de quantité -->
                                <form action="users/add_to_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1"> <!-- Valeur par défaut 1 -->
                                    <button type="submit" name="add_to_cart" class="btn btn-success">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucun produit disponible.</p>
        <?php endif; ?>
    </div>

    <?php include "src/php/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tooltip activation
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>
</html>

<?php
$conn->close();
?>

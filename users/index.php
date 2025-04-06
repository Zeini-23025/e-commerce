<?php
session_start();
include '../config/db_conn.php';

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
    </style>
</head>
<body>
    <?php include "../src/php/user_navbar.php"; ?>

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
                                <a href="products_by_category.php?category_id=<?= $category['id'] ?>" class="btn btn-primary mt-2">Voir les produits</a>
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
                            <?php if (!empty($product['image']) && file_exists("../" . $product['image'])): ?>
                                <img src="../<?= $product['image'] ?>" class="card-img-top" alt="Image du produit" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="../uploads/default.png" class="card-img-top" alt="Image par défaut" style="height: 200px; object-fit: cover;">
                            <?php endif; ?>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p class="card-text"><strong>Prix :</strong> <?= number_format($product['price'], 2) ?> €</p>
                                <p class="card-text"><strong>Quantité disponible :</strong> <?= htmlspecialchars($product['quantity']) ?></p>

                                <!-- Formulaire pour ajouter le produit au panier sans champ de quantité -->
                                <form action="add_to_cart.php" method="POST">
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

    <?php include "../src/php/footer.php"; ?>
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

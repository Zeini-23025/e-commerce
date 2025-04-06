<?php
session_start();
include '../config/db_conn.php';

if (isset($_GET['category_id'])) {
    $categoryId = intval($_GET['category_id']);

    $sqlProducts = "SELECT * FROM products WHERE category_id = $categoryId AND quantity > 0";
    $resultProducts = $conn->query($sqlProducts);

    $sqlCategoryName = "SELECT name FROM category WHERE id = $categoryId";
    $resultCategoryName = $conn->query($sqlCategoryName);
    $categoryName = $resultCategoryName->fetch_assoc()['name'];
} else {
    die("ID de catégorie manquant.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits de la catégorie - MonApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include "../src/php/user_navbar.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Produits de la catégorie : <?= htmlspecialchars($categoryName) ?></h1>

        <?php if ($resultProducts->num_rows > 0): ?>
            <div class="row mt-4">
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
            <p>Aucun produit disponible dans cette catégorie.</p>
        <?php endif; ?>
    </div>

    <?php include "../src/php/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>

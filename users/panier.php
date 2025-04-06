<?php
session_start();
include '../config/db_conn.php'; // Assurez-vous que la connexion à la base de données est incluse

// Vérifier si le panier existe dans la session, sinon l'initialiser
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Vérifier si l'utilisateur est connecté
$is_user_logged_in = isset($_SESSION['user_id']);
$user_id = $is_user_logged_in ? $_SESSION['user_id'] : null;

// Supprimer un produit du panier
if (isset($_POST['remove_from_cart'])) {
    $product_id = intval($_POST['product_id']);
    unset($_SESSION['cart'][$product_id]);  // Supprimer le produit du panier
}

// Ajouter plusieurs produits au panier en une seule fois
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;  // Mettre à jour la quantité
        } else {
            unset($_SESSION['cart'][$product_id]);  // Supprimer si la quantité est 0
        }
    }
}

// Calculer le total du panier
$total = 0;
foreach ($_SESSION['cart'] as $product_id => $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../src/php/user_navbar.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Mon Panier</h1>

        <?php if (count($_SESSION['cart']) > 0): ?>
            <form action="panier.php" method="POST">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Image</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $product_id => $item):
                            // Récupérer le nom et l'image du produit dans la base de données
                            $sqlProduct = "SELECT name, image, price FROM products WHERE id = $product_id";
                            $resultProduct = $conn->query($sqlProduct);
                            $product = $resultProduct->fetch_assoc();
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td>
                                    <?php if (!empty($product['image']) && file_exists("../" . $product['image'])): ?>
                                        <img src="../<?= $product['image'] ?>" alt="Image du produit" style="width: 100px; height: auto;">
                                    <?php else: ?>
                                        <img src="../uploads/default.png" alt="Image par défaut" style="width: 100px; height: auto;">
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($product['price'], 2) ?> €</td>
                                <td>
                                    <input type="number" name="quantity[<?= $product_id ?>]" value="<?= $item['quantity'] ?>" min="1" max="100" class="form-control">
                                </td>
                                <td><?= number_format($product['price'] * $item['quantity'], 2) ?> €</td>
                                <td>
                                    <form action="panier.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                                        <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4"><strong>Total</strong></td>
                            <td><strong><?= number_format($total, 2) ?> €</strong></td>
                        </tr>
                    </tbody>
                </table>

                <button type="submit" name="update_cart" class="btn btn-primary">Mettre à jour le panier</button>
            </form>

            <?php if ($is_user_logged_in): ?>
                <h3 class="mt-2">Finaliser la commande</h3>
                <form action="place_order.php" method="POST" enctype="multipart/form-data" class="m-2">
                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="total" value="<?= $total ?>">

                    <p>Notre numéro : <strong>30524849</strong></p>

                    <div class="mb-3">
                        <label for="payment_type" class="form-label">Choisir le type de paiement</label>
                        <select name="type" id="payment_type" class="form-select" required>
                            <option value="Bankily">Bankily</option>
                            <option value="Masrvi">Masrvi</option>
                            <option value="Sedade">Sedade</option>
                            <option value="Bimbank">Bimbank</option>
                            <option value="Click">Click</option>
                            <option value="Amanty">Amanty</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="transaction_code" class="form-label">Code de la transaction</label>
                        <input type="text" name="code" id="transaction_code" class="form-control" placeholder="ID de transfert" required>
                    </div>

                    <div class="mb-3">
                        <label for="transfer_receipt" class="form-label">Capture d'écran du transfert</label>
                        <input type="file" name="img" id="transfer_receipt" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Passer la commande</button>
                </form>

            <?php else: ?>
                <p>Veuillez vous <a href="../login.php">connecter</a> pour finaliser la commande.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </div>

    <?php include "../src/php/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

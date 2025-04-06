<?php
session_start();

// Vérifier si le panier existe dans la session, sinon l'initialiser
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Ajouter un produit au panier
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Vérifier si le produit existe déjà dans le panier
    if (isset($_SESSION['cart'][$product_id])) {
        // Si oui, augmenter la quantité
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        // Sinon, ajouter le produit au panier
        $_SESSION['cart'][$product_id] = [
            'quantity' => $quantity,
            'name' => 'Nom du produit', // À remplacer par une récupération réelle du produit
            'price' => 100, // À remplacer par une récupération réelle du prix
        ];
    }
}

// Rediriger vers la même page (index.php) pour rester sur la page d'accueil
header('Location: index.php?msg=Produit ajouté au panier');
exit();
?>

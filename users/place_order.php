<?php
session_start();
include '../config/db_conn.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour passer une commande.");
}

$user_id = $_SESSION['user_id'];
$total = 0;
$cart = $_SESSION['cart'];  // Récupérer le panier depuis la session

// Vérifier si le panier n'est pas vide
if (empty($cart)) {
    die("Votre panier est vide.");
}

// Calculer le total de la commande
foreach ($cart as $product_id => $item) {
    $total += $item['price'] * $item['quantity'];  // Calculer le total
}

// Vérifier si le formulaire est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que les clés sont définies avant de les utiliser
    if (isset($_POST['code'], $_POST['type'])) {
        $code = $conn->real_escape_string($_POST['code']);
        $type = $conn->real_escape_string($_POST['type']);
        $img = null;

        // Vérifier et télécharger l'image du transfert
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = "../uploads/payments/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imageName = basename($_FILES['img']['name']);
            $targetPath = $uploadDir . $imageName;

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($_FILES['img']['tmp_name']);

            if (in_array($fileType, $allowedTypes) && $_FILES['img']['size'] <= 2000000) {
                if (move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
                    $img = "uploads/payments/" . $imageName;
                } else {
                    die("Erreur lors du téléchargement de l'image.");
                }
            } else {
                die("Format d'image invalide ou taille trop grande.");
            }
        }

        // Insérer la commande dans la base de données
        $sqlOrder = "INSERT INTO orders (user_id, total, date, etat, code, img, type) 
                     VALUES ($user_id, $total, NOW(), 1, '$code', '$img', '$type')";

        if ($conn->query($sqlOrder)) {
            $order_id = $conn->insert_id;  // Récupérer l'ID de la commande insérée

            // Mettre à jour la quantité des produits dans la table `products`
            foreach ($cart as $product_id => $item) {
                $newQuantity = $item['quantity'];
                $sqlUpdateProduct = "UPDATE products SET quantity = quantity - $newQuantity WHERE id = $product_id";
                $conn->query($sqlUpdateProduct);

                // Optionnellement, vous pouvez aussi insérer dans une table `order_items` pour suivre les produits associés à la commande
                // $sqlOrderItem = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $newQuantity, {$item['price']})";
                // $conn->query($sqlOrderItem);
            }

            // Vider le panier après la commande
            unset($_SESSION['cart']);

            header("Location: index.php?msg=Commande passée avec succès !");
            exit();
        } else {
            echo "Erreur lors de la commande : " . $conn->error;
        }
    } else {
        die("Informations manquantes pour la commande.");
    }
}

$conn->close();
?>

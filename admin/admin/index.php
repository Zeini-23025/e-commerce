<?php
include '../../config/db_conn.php';
include '../../src/php/navbar.php';

$user_count_query = "SELECT COUNT(*) as total_users FROM users";
$user_count_result = mysqli_query($conn, $user_count_query);
$user_count = mysqli_fetch_assoc($user_count_result)['total_users'];

$order_count_query = "SELECT COUNT(*) as total_orders FROM orders";
$order_count_result = mysqli_query($conn, $order_count_query);
$order_count = mysqli_fetch_assoc($order_count_result)['total_orders'];

$product_count_query = "SELECT COUNT(*) as total_products FROM products";
$product_count_result = mysqli_query($conn, $product_count_query);
$product_count = mysqli_fetch_assoc($product_count_result)['total_products'];


$category_count_query = "SELECT COUNT(*) as total_categories FROM category";
$category_count_result = mysqli_query($conn, $category_count_query);
$category_count = mysqli_fetch_assoc($category_count_result)['total_categories'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1>Bienvenue dans le tableau de bord de l'administrateur</h1>
        <p>Choisissez une action dans le menu de navigation.</p>

        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text"><?php echo $user_count; ?> Utilisateurs</p>
                        <a href="../users/index_users.php" class="btn btn-light">Voir les utilisateurs</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Commandes</h5>
                        <p class="card-text"><?php echo $order_count; ?> Commandes</p>
                        <a href="../orders/index_order.php" class="btn btn-light">Voir les commandes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Produits</h5>
                        <p class="card-text"><?php echo $product_count; ?> Produits</p>
                        <a href="../products/index_product.php" class="btn btn-light">Voir les produits</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Catégories</h5>
                        <p class="card-text"><?php echo $category_count; ?> Catégories</p>
                        <a href="../category/index_category.php" class="btn btn-light">Voir les catégories</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
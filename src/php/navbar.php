<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}


if ($_SESSION['user_role'] != 1) {
    die("Accès refusé. Vous n'avez pas l'autorisation d'accéder à cette page.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Admin</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="../admin/index.php">Home</a> <!-- Page d'accueil -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../users/index_users.php">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../category/index_category.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../products/index_product.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../orders/index_order.php">Commandes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/add_admin_form.php">Ajouter Admin</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../src/php/logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
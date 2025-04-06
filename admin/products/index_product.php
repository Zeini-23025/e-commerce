<?php
include '../../config/db_conn.php';


$sql = "SELECT 
            p.id, 
            p.name, 
            p.description, 
            p.price, 
            p.quantity, 
            p.image, 
            c.name AS category_name 
        FROM products p
        LEFT JOIN category c ON p.category_id = c.id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Erreur SQL : " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">


    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Liste des Produits</h1>
        <a href="add_product.php" class="btn btn-primary mb-3">Ajouter un produit</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Catégorie</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['description']); ?></td>
                            <td><?= number_format($row['price'], 2); ?> €</td>
                            <td><?= htmlspecialchars($row['quantity']); ?></td>
                            <td><?= htmlspecialchars($row['category_name'] ?? "Non catégorisé"); ?></td>
                            <td>
                                <?php if (!empty($row['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $row['image'])): ?>
                                    <img src="/<?= htmlspecialchars($row['image']); ?>" alt="Image du produit" style="height: 50px;">
                                <?php else: ?>
                                    <img src="/uploads/default.png" alt="Image par défaut" style="height: 50px;">
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Aucun produit trouvé.</td>
                    </tr>
                <?php endif; ?>
                <?php mysqli_close($conn); ?>
            </tbody>
        </table>
    </main>


    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
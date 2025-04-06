<?php
include '../../config/db_conn.php';


$sql = "SELECT 
            orders.id, 
            users.nom AS user_nom, 
            users.prenom AS user_prenom, 
            orders.total, 
            orders.date, 
            orders.etat, 
            orders.code, 
            orders.img, 
            orders.type
        FROM orders
        JOIN users ON orders.user_id = users.id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Erreur SQL : " . mysqli_error($conn);
    exit();
}


function formatEtat($etat)
{
    switch ($etat) {
        case 1:
            return "En attente";
        case 2:
            return "Annulé";
        case 3:
            return "Expédiée";
        default:
            return "Inconnu";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">


    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Liste des Commandes</h1>
        <a href="add_order.php" class="btn btn-primary mb-3">Ajouter une commande</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de l'utilisateur</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>État</th>
                    <th>Code</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['user_nom'] . " " . $row['user_prenom']); ?></td>
                            <td><?= number_format($row['total'], 2); ?> €</td>
                            <td><?= htmlspecialchars($row['date']); ?></td>
                            <td><?= formatEtat($row['etat']); ?></td>
                            <td><?= htmlspecialchars($row['code']); ?></td>
                            <td>
                                <?php if (!empty($row['img']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $row['img'])): ?>
                                    <img src="/<?= htmlspecialchars($row['img']); ?>" alt="Image" style="height: 50px;">
                                <?php else: ?>
                                    <img src="/uploads/default.png" alt="Image par défaut" style="height: 50px;">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['type']); ?></td>
                            <td>
                                <a href="edit_order.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="delete_order.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">Aucune commande trouvée.</td>
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
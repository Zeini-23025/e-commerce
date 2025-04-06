<?php
session_start();
include '../config/db_conn.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Rediriger vers la page de connexion
    exit();
}

$user_id = $_SESSION['user_id'];

// Vérifier si un filtre d'état est appliqué
$etat_filter = isset($_POST['etat']) ? intval($_POST['etat']) : null;
$sqlCondition = "";

if ($etat_filter !== null) {
    $sqlCondition = "AND o.etat = $etat_filter";
}

// Récupérer les commandes de l'utilisateur depuis la base de données avec un filtre d'état
$sqlOrders = "SELECT o.id AS order_id, o.total, o.date, o.etat, u.nom, u.prenom
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              WHERE o.user_id = $user_id $sqlCondition
              ORDER BY o.date DESC";

$resultOrders = $conn->query($sqlOrders);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../src/php/user_navbar.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Historique de vos commandes</h1>

        <!-- Formulaire de filtrage des commandes -->
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="etat">Filtrer par État :</label>
                <select name="etat" id="etat" class="form-select">
                    <option value="">Tous</option>
                    <option value="1" <?= $etat_filter == 1 ? 'selected' : '' ?>>En attente</option>
                    <option value="2" <?= $etat_filter == 2 ? 'selected' : '' ?>>Annulé</option>
                    <option value="3" <?= $etat_filter == 3 ? 'selected' : '' ?>>Expédiée</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Appliquer le filtre</button>
        </form>

        <!-- Affichage des commandes -->
        <?php if ($resultOrders->num_rows > 0): ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID de la commande</th>
                        <th>Nom de l'utilisateur</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $resultOrders->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_id']) ?></td>
                            <td><?= htmlspecialchars($order['nom']) . " " . htmlspecialchars($order['prenom']) ?></td>
                            <td><?= number_format($order['total'], 2) ?> €</td>
                            <td><?= htmlspecialchars($order['date']) ?></td>
                            <td>
                                <?php
                                switch ($order['etat']) {
                                    case 1:
                                        echo "En attente";
                                        break;
                                    case 2:
                                        echo "Annulé";
                                        break;
                                    case 3:
                                        echo "Expédiée";
                                        break;
                                    default:
                                        echo "Inconnu";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Vous n'avez pas encore passé de commande ou aucune commande ne correspond à votre filtre.</p>
        <?php endif; ?>
    </div>

    <?php include "../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

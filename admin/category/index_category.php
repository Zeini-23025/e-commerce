<?php
include '../../config/db_conn.php';

$sql = "SELECT * FROM category";
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
    <title>Liste des Catégories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">


    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Liste des Catégories</h1>
        <a href="add_category.php" class="btn btn-primary mb-3">Ajouter une catégorie</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['description']}</td>
                                <td>
                                    <a href='edit_category.php?id={$row['id']}' class='btn btn-warning btn-sm'>Modifier</a>
                                    <a href='delete_category.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette catégorie ?\");'>Supprimer</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>Aucune catégorie trouvée.</td></tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </main>


    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
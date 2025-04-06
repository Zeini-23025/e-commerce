<?php
include '../../config/db_conn.php';
include "../../src/php/navbar.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <main class="container my-5">
        <h1 class="text-center mb-4">Liste des Utilisateurs</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $etat = $row['etat'] == 1 ? 'Actif' : 'Inactif';
                        $toggleAction = $row['etat'] == 1 ? 'Désactiver' : 'Activer';
                        $toggleValue = $row['etat'] == 1 ? 0 : 1;

                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nom']}</td>
                                <td>{$row['prenom']}</td>
                                <td>{$row['email']}</td>
                                <td>$etat</td>
                                <td>
                                    <a class='btn btn-warning btn-sm' href='toggle_user.php?id={$row['id']}&etat=$toggleValue'>$toggleAction</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Aucun utilisateur trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <!--  footer -->
    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
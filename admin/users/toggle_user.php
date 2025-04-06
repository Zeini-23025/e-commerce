<?php
include '../../config/db_conn.php';

if (isset($_GET['id']) && isset($_GET['etat'])) {
    $id = $_GET['id'];
    $etat = $_GET['etat'];

    $sql = "UPDATE users SET etat=$etat WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        $msg = $etat == 1 ? "Utilisateur activé avec succès" : "Utilisateur désactivé avec succès";
        header("Location: index_users.php?msg=$msg");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
} else {
    header("Location: index_users.php?msg=Requête invalide");
    exit();
}

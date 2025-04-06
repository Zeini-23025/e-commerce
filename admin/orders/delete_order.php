<?php
include '../../config/db_conn.php';


if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    
    $sql = "DELETE FROM orders WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index_order.php?msg=Commande supprimée avec succès");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
} else {
    echo "Aucun ID fourni pour la commande.";
}
?>

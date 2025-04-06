<?php
include '../../config/db_conn.php';

$id = $_GET["id"];
$sql = "DELETE FROM category WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header("Location: index_category.php?msg=Catégorie supprimée avec succès");
    exit();
} else {
    echo "Erreur : " . mysqli_error($conn);
}

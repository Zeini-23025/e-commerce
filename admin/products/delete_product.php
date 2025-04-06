<?php
include '../../config/db_conn.php';


if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = intval($_GET["id"]);


    $check_sql = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        $delete_sql = "DELETE FROM products WHERE id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($delete_stmt, "i", $id);

        if (mysqli_stmt_execute($delete_stmt)) {
            header("Location: index_product.php?msg=Produit supprimé avec succès");
            exit();
        } else {
            echo "Erreur lors de la suppression : " . mysqli_error($conn);
        }
    } else {
        echo "Erreur : Produit introuvable.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "ID invalide.";
}

mysqli_close($conn);

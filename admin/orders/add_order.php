<?php
include '../../config/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $total = $_POST["total"];
    $etat = $_POST["etat"];
    $code = $_POST["code"];
    $type = $_POST["type"];

    $target_dir = "../../uploads/orders/";
    $img = null;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    if (!empty($_FILES["img"]["name"])) {
        $img = basename($_FILES["img"]["name"]);
        $target_file = $target_dir . $img;

        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileType, $allowedTypes)) {
            echo "Seules les images JPG, JPEG, PNG et GIF sont acceptées.";
            exit();
        }

        if ($_FILES["img"]["size"] > 2000000) {
            echo "L'image est trop volumineuse (max : 2 Mo).";
            exit();
        }

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $img = "uploads/orders/" . $img;
        } else {
            echo "Erreur lors de l'upload de l'image.";
            exit();
        }
    }

    $sql = "INSERT INTO orders (user_id, total, etat, code, img, type) 
            VALUES ('$user_id', '$total', '$etat', '$code', '$img', '$type')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index_order.php?msg=Commande ajoutée avec succès");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Ajouter une Commande</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="user_id" class="form-label">Utilisateur :</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <?php
                    $users = mysqli_query($conn, "SELECT id, nom FROM users");
                    while ($user = mysqli_fetch_assoc($users)) {
                        echo "<option value='{$user['id']}'>{$user['nom']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Total :</label>
                <input type="number" name="total" id="total" class="form-control" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="etat" class="form-label">État :</label>
                <select name="etat" id="etat" class="form-select" required>
                    <option value="1">En attente</option>
                    <option value="2">Annulé</option>
                    <option value="3">Expédiée</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Code :</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Télécharger une image :</label>
                <input type="file" name="img" id="img" class="form-control">
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type :</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="Bankily">Bankily</option>
                    <option value="Masrvi">Masrvi</option>
                    <option value="Sedade">Sedade</option>
                    <option value="Bimbank">Bimbank</option>
                    <option value="Click">Click</option>
                    <option value="Amanty">Amanty</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </main>

    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

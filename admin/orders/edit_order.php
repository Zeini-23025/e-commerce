<?php
include '../../config/db_conn.php';

if (!isset($_GET["id"])) {
    die("ID de commande manquant.");
}

$id = intval($_GET["id"]);
$sql = "SELECT * FROM orders WHERE id=$id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Commande introuvable.");
}

$order = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $total = $_POST["total"];
    $etat = $_POST["etat"];
    $code = $_POST["code"];
    $type = $_POST["type"];

    $img = $order['img'];
    $target_dir = "../../uploads/orders/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    if (!empty($_FILES["img"]["name"])) {
        $img = basename($_FILES["img"]["name"]);
        $target_file = $target_dir . $img;

        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileType, $allowedTypes)) {
            die("Seules les images JPG, JPEG, PNG et GIF sont acceptées.");
        }

        if ($_FILES["img"]["size"] > 2000000) {
            die("L'image est trop volumineuse (max : 2 Mo).");
        }

        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            $img = "uploads/orders/" . $img;
        } else {
            die("Erreur lors de l'upload de l'image.");
        }
    }

    $sql = "UPDATE orders 
            SET user_id='$user_id', total='$total', etat='$etat', code='$code', img='$img', type='$type' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index_order.php?msg=Commande mise à jour avec succès");
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
    <title>Modifier une Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Modifier une Commande</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="user_id" class="form-label">Utilisateur :</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <?php
                    $users = mysqli_query($conn, "SELECT id, nom FROM users");
                    while ($user = mysqli_fetch_assoc($users)) {
                        $selected = ($user['id'] == $order['user_id']) ? "selected" : "";
                        echo "<option value='{$user['id']}' $selected>{$user['nom']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Total :</label>
                <input type="number" name="total" id="total" class="form-control" value="<?= htmlspecialchars($order['total']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="etat" class="form-label">État :</label>
                <select name="etat" id="etat" class="form-select" required>
                    <option value="1" <?= ($order['etat'] == 1) ? "selected" : ""; ?>>En attente</option>
                    <option value="2" <?= ($order['etat'] == 2) ? "selected" : ""; ?>>Annulé</option>
                    <option value="3" <?= ($order['etat'] == 3) ? "selected" : ""; ?>>Expédiée</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="code" class="form-label">Code :</label>
                <input type="text" name="code" id="code" class="form-control" value="<?= htmlspecialchars($order['code']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Image actuelle :</label>
                <div>
                    <img src="../../<?= htmlspecialchars($order['img']); ?>" alt="Image actuelle" style="height: 100px;">
                </div>
                <label for="img" class="form-label">Télécharger une nouvelle image :</label>
                <input type="file" name="img" id="img" class="form-control">
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type :</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="Bankily" <?= ($order['type'] == "Bankily") ? "selected" : ""; ?>>Bankily</option>
                    <option value="Masrvi" <?= ($order['type'] == "Masrvi") ? "selected" : ""; ?>>Masrvi</option>
                    <option value="Sedade" <?= ($order['type'] == "Sedade") ? "selected" : ""; ?>>Sedade</option>
                    <option value="Bimbank" <?= ($order['type'] == "Bimbank") ? "selected" : ""; ?>>Bimbank</option>
                    <option value="Click" <?= ($order['type'] == "Click") ? "selected" : ""; ?>>Click</option>
                    <option value="Amanty" <?= ($order['type'] == "Amanty") ? "selected" : ""; ?>>Amanty</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </main>

    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

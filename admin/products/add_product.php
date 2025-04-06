<?php
include '../../config/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category_id = $_POST["category_id"];
    $quantity = $_POST["quantity"];
    $image_path = null;


    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../../uploads/products/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if ($_FILES["image"]["size"] <= 2000000) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = "uploads/products/" . $image_name;
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                    exit();
                }
            } else {
                echo "L'image est trop volumineuse. Maximum : 2 Mo.";
                exit();
            }
        } else {
            echo "Type de fichier non valide. Seules les images JPG, JPEG, PNG et GIF sont acceptées.";
            exit();
        }
    }


    $sql = "INSERT INTO products (name, description, price, category_id, quantity, image) 
            VALUES ('$name', '$description', '$price', '$category_id', '$quantity', '$image_path')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index_product.php?msg=Produit ajouté avec succès");
        exit();
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

$category_query = "SELECT id, name FROM category";
$category_result = mysqli_query($conn, $category_query);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">


    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Ajouter un Produit</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prix :</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Catégorie :</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">-- Sélectionnez une catégorie --</option>
                    <?php
                    if (mysqli_num_rows($category_result) > 0) {
                        while ($row = mysqli_fetch_assoc($category_result)) {
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                    } else {
                        echo "<option value=''>Aucune catégorie disponible</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantité :</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image du produit :</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </main>


    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
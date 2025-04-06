<?php
include '../../config/db_conn.php';

$id = $_GET["id"];
$sql = "SELECT * FROM category WHERE id=$id";
$result = mysqli_query($conn, $sql);
$category = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];

    $sql = "UPDATE category 
            SET name='$name' ,description='$description'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index_category.php?msg=Catégorie mise à jour avec succès");
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
    <title>Modifier une Catégorie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">


    <?php include "../../src/php/navbar.php"; ?>

    <main class="container my-5">
        <h1 class="text-center mb-4">Modifier une Catégorie</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom de la catégorie</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Nom de la catégorie</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $category['description']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </main>


    <?php include "../../src/php/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
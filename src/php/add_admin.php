<?php

include '../../config/db_conn.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $query = "INSERT INTO `users` (`nom`, `prenom`, `email`, `etat`, `role`, `password`) 
              VALUES (?, ?, ?, 1, 1, ?)";


    if ($stmt = $conn->prepare($query)) {

        $stmt->bind_param("ssss", $nom, $prenom, $email, $hashed_password);


        if ($stmt->execute()) {
            echo "<p>Administrateur ajouté avec succès.</p>";
        } else {
            echo "<p>Erreur lors de l'ajout de l'administrateur.</p>";
        }


        $stmt->close();
    } else {
        echo "<p>Erreur de préparation de la requête.</p>";
    }
}

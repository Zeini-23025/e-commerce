<?php
session_start();
include '../../config/db_conn.php';

$error_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error_msg = "Cet email est déjà utilisé.";
    } else {
        $insert_sql = "INSERT INTO users (nom, prenom, email, password, role, etat) VALUES ('$nom', '$prenom', '$email', '$hashed_password', 2, 1)";
        if (mysqli_query($conn, $insert_sql)) {
            $_SESSION['success_msg'] = "Inscription réussie ! Connectez-vous.";
            header("Location: ../../login.php");
            exit();
        } else {
            $error_msg = "Erreur lors de l'inscription : " . mysqli_error($conn);
        }
    }
}

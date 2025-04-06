<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";


$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

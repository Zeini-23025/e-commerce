<?php
session_start();


if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();

    header("Location: ../../users/index.php");
    exit();
} else {
    header("Location: ../../users/index.php");
    exit();
}

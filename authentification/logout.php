<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Supprimer le cookie Remember Me si existant
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/'); // expire le cookie
}

// Rediriger vers login
header("Location: ../authentification/login.php");
exit();
?>
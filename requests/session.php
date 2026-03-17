<?php
// session.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour vérifier si l'utilisateur est connecté
function isUserLoggedIn() {
    return isset($_SESSION['user_uuid']) && !empty($_SESSION['user_uuid']);
}

// Fonction pour récupérer les infos de l'utilisateur connecté
function getLoggedInUser() {
    if (isUserLoggedIn()) {
        return [
            'user_uuid' => $_SESSION['user_uuid'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'user_email' => $_SESSION['user_email'] ?? null,
            'user_role' => $_SESSION['user_role'] ?? null,
            'user_picture' => $_SESSION['user_picture'] ?? null,
        ];
    }
    return null;
}

// Fonction pour connecter un utilisateur (après login réussi)
function loginUser($user) {
    $_SESSION['user_uuid'] = $user['user_uuid'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_email'] = $user['user_email'];
    $_SESSION['user_role'] = $user['user_role'];
    $_SESSION['user_picture'] = $user['user_picture'];
    $_SESSION['last_connection_date'] = date('Y-m-d H:i:s');
}

// Fonction pour déconnecter un utilisateur
function logoutUser() {
    session_unset();
    session_destroy();
}
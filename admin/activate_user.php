<?php
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

include("../database/connexion.php");

if (isset($_GET['user_uuid'])) {

    $user_uuid = $_GET['user_uuid'];

    try {
        // Mise à jour : is_active = 1
        $sql = "UPDATE users SET user_status = 'active', updated_at = NOW() WHERE user_uuid = :user_uuid";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':user_uuid', $user_uuid, PDO::PARAM_STR);
        $stmt->execute();

        $message = 'Utilisateur activé avec succès.';
        $type = 'success';

    } catch (PDOException $e) {
        $message = "Erreur lors de l'activation : " . $e->getMessage();
        $type = 'danger';
    }

} else {
    $message = "Paramètre manquant.";
    $type = 'warning';
}

// Redirection vers la liste des utilisateurs avec message
header("Location: users.php?message=" . urlencode($message) . "&type=" . $type);
exit();
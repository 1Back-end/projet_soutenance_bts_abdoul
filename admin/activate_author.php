<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

if (isset($_GET['author_uuid'])) {
    $author_uuid = $_GET['author_uuid'];

    try {
        // Changement : is_active passe à 1
        $sql = "UPDATE authors SET is_active = 1, updated_at = NOW() WHERE author_uuid = :author_uuid";
        $stmt = $connexion->prepare($sql);
        
        $stmt->bindParam(':author_uuid', $author_uuid, PDO::PARAM_STR);
        $stmt->execute();

        $message = 'Auteur activé avec succès.';
        $type = 'success';
    } catch (PDOException $e) {
        $message = "Erreur lors de l'activation : " . $e->getMessage();
        $type = 'danger';
    }
} else {
    $message = "Paramètres manquants.";
    $type = 'warning';
}

header("Location: authors.php?message=" . urlencode($message) . "&type=" . $type);
exit();
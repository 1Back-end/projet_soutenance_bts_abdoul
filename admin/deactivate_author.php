<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

if (isset($_GET['author_uuid'])) {
    $author_uuid = $_GET['author_uuid'];

    try {
        $sql = "UPDATE authors SET is_active = 0, updated_at = NOW() WHERE author_uuid = :author_uuid";
        $stmt = $connexion->prepare($sql);
        
        // Correction 2 : Suppression de bindParam(':status') qui n'existe plus dans le SQL
        $stmt->bindParam(':author_uuid', $author_uuid, type: PDO::PARAM_STR);
        $stmt->execute();

        $message = 'Auteur désactivé avec succès.';
        $type = 'success';
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour du statut : " . $e->getMessage();
        $type = 'danger';
    }
} else {
    $message = "Paramètres manquants.";
    $type = 'warning';
}

// Correction 3 : authors.php (au lieu de authors.php.php)
header("Location: authors.php?message=" . urlencode($message) . "&type=" . $type);
exit();
<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

if (isset($_GET['category_uuid'])) {
    $category_uuid = $_GET['category_uuid'];

    try {
        $sql = "UPDATE category_books SET is_active = 0, updated_at = NOW() WHERE category_uuid = :category_uuid";
        $stmt = $connexion->prepare($sql);
        
        // Correction 2 : Suppression de bindParam(':status') qui n'existe plus dans le SQL
        $stmt->bindParam(':category_uuid', $category_uuid, type: PDO::PARAM_STR);
        $stmt->execute();

        $message = 'categorie désactivé avec succès.';
        $type = 'success';
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour du statut : " . $e->getMessage();
        $type = 'danger';
    }
} else {
    $message = "Paramètres manquants.";
    $type = 'warning';
}

// Correction 3 : category_books.php (au lieu de category_books.php.php)
header("Location: category_books.php?message=" . urlencode($message) . "&type=" . $type);
exit();
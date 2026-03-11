<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

if (isset($_GET['category_books_uuid'])) {
    $category_books_uuid = $_GET['category_books_uuid'];

    try {
        // Changement : is_active passe à 1
        $sql = "UPDATE category_books SET is_active = 1, updated_at = NOW() WHERE category_books_uuid = :category_books_uuid";
        $stmt = $connexion->prepare($sql);
        
        $stmt->bindParam(':category_books_uuid', $category_books_uuid, PDO::PARAM_STR);
        $stmt->execute();

        $message = 'categorie activé avec succès.';
        $type = 'success';
    } catch (PDOException $e) {
        $message = "Erreur lors de l'activation : " . $e->getMessage();
        $type = 'danger';
    }
} else {
    $message = "Paramètres manquants.";
    $type = 'warning';
}

header("Location: category_books.php?message=" . urlencode($message) . "&type=" . $type);
exit();
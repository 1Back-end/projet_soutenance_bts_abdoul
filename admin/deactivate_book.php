<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

if (isset($_GET['book_uuid'])) {
    $book_uuid = $_GET['book_uuid'];

    try {
        // Mettre le livre en inactif
        $sql = "UPDATE books SET is_active = 0, updated_at = NOW() WHERE book_uuid = :book_uuid";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':book_uuid', $book_uuid, PDO::PARAM_STR);
        $stmt->execute();

        $message = 'Livre désactivé avec succès.';
        $type = 'success';
    } catch (PDOException $e) {
        $message = "Erreur lors de la mise à jour du statut : " . $e->getMessage();
        $type = 'danger';
    }
} else {
    $message = "Paramètres manquants.";
    $type = 'warning';
}

// Redirection vers la liste des livres avec message
header("Location: books.php?message=" . urlencode($message) . "&type=" . $type);
exit();
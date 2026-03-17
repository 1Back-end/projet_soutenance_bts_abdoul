<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit']) && isset($_GET['category_uuid'])) {

    $category_uuid = $_GET['category_uuid'];

    $category_name = htmlspecialchars($_POST['category_name'] ?? '');
    $category_code = htmlspecialchars($_POST['category_code'] ?? '');
    $category_description = htmlspecialchars($_POST['category_description'] ?? '');

    $updated_by = $_SESSION['user_uuid'] ?? null;

    if (!$updated_by) {
        $erreur = "Erreur d'authentification : session expirée.";
    } else {

        try {

            // Vérifier si le nom ou le code existe déjà
            $checkQuery = "SELECT category_name, category_code
                           FROM category_books 
                           WHERE (category_name = :category_name 
                           OR category_code = :category_code)
                           AND category_uuid != :category_uuid
                           AND is_deleted = 0
                           LIMIT 1";

            $stmtCheck = $connexion->prepare($checkQuery);
            $stmtCheck->execute([
                ':category_name' => $category_name,
                ':category_code' => $category_code,
                ':category_uuid' => $category_uuid
            ]);

            $existingCategory = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingCategory) {

                if ($existingCategory['category_name'] === $category_name) {
                    $erreur = "Ce nom de catégorie existe déjà.";
                } elseif ($existingCategory['category_code'] === $category_code) {
                    $erreur = "Ce code de catégorie existe déjà.";
                }

            } else {

                $query = "UPDATE category_books SET
                            category_name = ?,
                            category_code = ?,
                            category_description = ?,
                            updated_by = ?,
                            updated_at = NOW()
                          WHERE category_uuid = ?";

                $stmt = $connexion->prepare($query);

                $stmt->execute([
                    $category_name,
                    $category_code,
                    $category_description,
                    $updated_by,
                    $category_uuid
                ]);

                $success = "Catégorie de livres modifiée avec succès !";
                echo "<script>setTimeout(function() { window.location.href = 'category_books.php'; }, 2000);</script>";
            }

        } catch (PDOException $e) {
            $erreur = "Erreur technique : " . $e->getMessage();
        }
    }
}
?>
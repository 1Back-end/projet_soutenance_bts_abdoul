<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit']) && isset($_GET['category_books_uuid'])) {

    $category_uuid = $_GET['category_books_uuid'];

    $category_name = htmlspecialchars($_POST['category_books_name'] ?? '');
    $category_description = htmlspecialchars($_POST['category_books_description'] ?? '');
    $category_status = isset($_POST['category_books_is_active']) ? (int)$_POST['category_books_is_active'] : 1;
    $category_image = $_FILES['category_books_image'] ?? null;

    $updated_by = $_SESSION['user_uuid'] ?? null;

    if (!$updated_by) {
        $erreur = "Erreur d'authentification : session expirée.";
    } else {

        try {

            // Vérification si le nom de catégorie existe déjà
            $checkQuery = "SELECT category_uuid 
                           FROM category_books 
                           WHERE category_name = :name
                           AND category_uuid != :category_uuid
                           AND is_deleted = 0
                           LIMIT 1";

            $stmtCheck = $connexion->prepare($checkQuery);
            $stmtCheck->execute([
                ':name' => $category_books_name,
                ':category_uuid' => $category_books_uuid
            ]);

            if ($stmtCheck->fetch()) {
                $erreur = "Ce nom de catégorie existe déjà.";
            } else {

                $image_name = null;
                $upload_ok = true;

                if ($category_image && $category_image['tmp_name']) {

                    $allowed_extensions = ['jpg','jpeg','png','gif'];
                    $extension = strtolower(pathinfo($category_image['name'], PATHINFO_EXTENSION));

                    if (in_array($extension, $allowed_extensions)) {
                        $image_name = bin2hex(random_bytes(8))."_".time().".".$extension;

                        if (!move_uploaded_file($category_image['tmp_name'], "../uploads/".$image_name)) {
                            $erreur = "Échec de l'upload de l'image.";
                            $upload_ok = false;
                        }

                    } else {
                        $erreur = "Extension de l'image non autorisée.";
                        $upload_ok = false;
                    }
                }

                if ($upload_ok) {

                    if ($image_name) {
                        $query = "UPDATE category_books SET
                                    category_name = ?,
                                    category_description = ?,
                                    category_image = ?,
                                    is_active = ?,
                                    updated_by = ?,
                                    updated_at = NOW()
                                  WHERE category_uuid = ?";

                        $stmt = $connexion->prepare($query);
                        $stmt->execute([
                            $category_name,
                            $category_description,
                            $image_name,
                            $category_is_active,
                            $updated_by,
                            $category_uuid
                        ]);

                    } else {
                        $query = "UPDATE category_books SET
                                    category_name = ?,
                                    category_description = ?,
                                    is_active = ?,
                                    updated_by = ?,
                                    updated_at = NOW()
                                  WHERE category_uuid = ?";

                        $stmt = $connexion->prepare($query);
                        $stmt->execute([
                            $category_name,
                            $category_description,
                            $category_is_active,
                            $updated_by,
                            $category_uuid
                        ]);
                    }

                    $success = "Catégorie de livres modifiée avec succès !";
                    echo "<script>setTimeout(function() { window.location.href = 'category_books.php'; }, 3000);</script>";
                }
            }

        } catch (PDOException $e) {
            $erreur = "Erreur technique : ".$e->getMessage();
        }
    }
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit'])) {

    // Récupération et nettoyage des champs
    $category_books_name = trim(htmlspecialchars($_POST['category_books_name'] ?? ''));
    $category_books_description = trim(htmlspecialchars($_POST['category_books_description'] ?? ''));
    $category_is_active = isset($_POST['category_is_active']) ? (int)$_POST['category_is_active'] : 1;
    $category_books_image = $_FILES['category_books_image'] ?? null;

    // Vérification des champs obligatoires
    if (empty($category_name)) {
        $erreur = "Veuillez saisir le nom de la catégorie !";
    } else {
        $added_by = $_SESSION['user_uuid'] ?? null;

        if (!$added_by) {
            $erreur = "Erreur d'authentification : session expirée. Veuillez vous reconnecter.";
        } else {
            try {
                // Vérifier si la catégorie existe déjà
                $checkQuery = "SELECT category_books_name FROM category_books 
                               WHERE category_books_name = :name AND is_deleted = 0 LIMIT 1";
                $stmtCheck = $connexion->prepare($checkQuery);
                $stmtCheck->execute([':name' => $category_books_name]);
                $existingCategory = $stmtCheck->fetch();

                if ($existingCategory) {
                    $erreur = "Cette catégorie existe déjà.";
                } else {
                    $image_name = null;
                    $upload_ok = true;

                    if ($category_image && $category_books_image['tmp_name']) {
                        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $extension = strtolower(pathinfo($category_books_image['name'], PATHINFO_EXTENSION));

                        if (in_array($extension, $allowed_extensions)) {
                            $image_name = bin2hex(random_bytes(8)) . "_" . time() . "." . $extension;
                            if (!move_uploaded_file($category_image['tmp_name'], "../uploads/" . $image_name)) {
                                $erreur = "Échec de l'upload de l'image.";
                                $upload_ok = false;
                            }
                        } else {
                            $erreur = "Extension de l'image non autorisée.";
                            $upload_ok = false;
                        }
                    }

                    if ($upload_ok) {
                        $category_books_uuid = bin2hex(random_bytes(16)); 

                        $query = "INSERT INTO category_books (
                                    category_uuid, 
                                    category_name, 
                                    category_description, 
                                    category_image, 
                                    added_by,
                                    is_active, 
                                    created_at, 
                                    updated_at
                                ) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

                        $stmt = $connexion->prepare($query);
                        $stmt->execute([
                            $category_uuid,
                            $category_name,
                            $category_description,
                            $image_name,
                            $added_by,
                            $category_status
                        ]);

                        $success = "Catégorie de livres enregistrée avec succès !";
                        echo "<script>setTimeout(function() { window.location.href = 'category_books.php'; }, 2000);</script>";
                    }
                }
            } catch (PDOException $e) {
                $erreur = "Erreur technique : " . $e->getMessage();
            }
        }
    }
}
?>
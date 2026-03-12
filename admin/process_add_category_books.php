<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit'])) {

    $category_name = trim(htmlspecialchars($_POST['category_name'] ?? ''));
    $category_description = trim(htmlspecialchars($_POST['category_description'] ?? ''));

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
                $checkQuery = "SELECT category_name FROM category_books 
                               WHERE category_name = :category_name AND is_deleted = 0 LIMIT 1";

                $stmtCheck = $connexion->prepare($checkQuery);
                $stmtCheck->execute([':category_name' => $category_name]);
                $existingCategory = $stmtCheck->fetch();

                if ($existingCategory) {
                    $erreur = "Cette catégorie existe déjà.";
                } else {
                    $category_uuid = bin2hex(random_bytes(16)); 

                    $query = "INSERT INTO category_books (
                                category_uuid, 
                                category_name, 
                                category_description, 
                                added_by
                              ) VALUES (?, ?, ?, ?)";

                    $stmt = $connexion->prepare($query);
                    $stmt->execute([
                        $category_uuid,
                        $category_name,
                        $category_description,
                        $added_by,
                    ]);

                    $success = "Catégorie de livres enregistrée avec succès !";
                    echo "<script>setTimeout(function() { window.location.href = 'category_books.php'; }, 2000);</script>";
                }

            } catch (PDOException $e) {
                $erreur = "Erreur technique : " . $e->getMessage();
            } // <-- fin du catch
        }
    }
}
?>
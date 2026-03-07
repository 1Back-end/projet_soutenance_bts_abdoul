<?php
// Assure-toi que session_start() est bien présent en haut du fichier ou dans ton header
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit'])) {

    // Récupération et nettoyage des champs
    $author_full_name = trim(htmlspecialchars($_POST['author_full_name'] ?? ''));
    $author_email = trim(htmlspecialchars($_POST['author_email'] ?? ''));
    $author_nationality = trim(htmlspecialchars($_POST['author_nationality'] ?? ''));
    $author_phone_number = trim(htmlspecialchars($_POST['author_phone_number'] ?? ''));
    $author_second_phone_number = trim(htmlspecialchars($_POST['author_second_phone_number'] ?? ''));
    $photo = $_FILES['author_picture'] ?? null;
    
    // Vérification des champs obligatoires
    if (empty($author_full_name) || empty($author_email) || empty($author_nationality) || empty($author_phone_number)) {
        $erreur = "Veuillez remplir tous les champs obligatoires !";
    } else {
        // Récupération de l'ID de l'admin connecté
        $added_by = $_SESSION['user_uuid'] ?? null;

        if (!$added_by) {
            $erreur = "Erreur d'authentification : session expirée. Veuillez vous reconnecter.";
        } else {
            try {
                // Vérification si Email ou Téléphone existe déjà
                $checkQuery = "SELECT author_email, author_phone_number FROM authors 
                               WHERE (author_email = :email OR author_phone_number = :phone) 
                               AND is_deleted = 0 LIMIT 1";
                $stmtCheck = $connexion->prepare($checkQuery);
                $stmtCheck->execute([
                    ':email' => $author_email,
                    ':phone' => $author_phone_number
                ]);
                $existingAuthor = $stmtCheck->fetch();

                if ($existingAuthor) {
                    if ($existingAuthor['author_email'] === $author_email) {
                        $erreur = "Cet email est déjà utilisé.";
                    } else {
                        $erreur = "Ce numéro de téléphone est déjà attribué.";
                    }
                } else {
                    $photo_name = null;
                    $upload_ok = true;

                    if ($photo && $photo['tmp_name']) {
                        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

                        if (in_array($extension, $allowed_extensions)) {
                            $photo_name = bin2hex(random_bytes(8)) . "_" . time() . "." . $extension;
                            if (!move_uploaded_file($photo['tmp_name'], "../uploads/" . $photo_name)) {
                                $erreur = "Échec de l'upload de la photo.";
                                $upload_ok = false;
                            }
                        } else {
                            $erreur = "Extension photo non autorisée.";
                            $upload_ok = false;
                        }
                    }

                    if ($upload_ok) {
                        $author_uuid = bin2hex(random_bytes(16)); 

                        $query = "INSERT INTO authors (
                                    author_uuid, 
                                    author_full_name, 
                                    author_email, 
                                    author_nationality, 
                                    author_phone_number, 
                                    author_second_phone_number, 
                                    author_picture,
                                    added_by,
                                    is_active, 
                                    created_at, 
                                    updated_at
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())";

                        $stmt = $connexion->prepare($query);
                        $stmt->execute([
                            $author_uuid,               
                            $author_full_name,          
                            $author_email,              
                            $author_nationality,        
                            $author_phone_number,       
                            $author_second_phone_number,
                            $photo_name,                
                            $added_by                   
                        ]);

                        $success = "Auteur enregistré avec succès !";
                        echo "<script>setTimeout(function() { window.location.href = 'authors.php'; }, 3000);</script>";
                    }
                }
            } catch (PDOException $e) {
                $erreur = "Erreur technique : " . $e->getMessage();
            }
        }
    }
}
?>
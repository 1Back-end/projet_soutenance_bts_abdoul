<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit']) && isset($_GET['author_uuid'])) {

    $author_uuid = $_GET['author_uuid'];

    $author_full_name = htmlspecialchars($_POST['author_full_name'] ?? '');
    $author_email = htmlspecialchars($_POST['author_email'] ?? '');
    $author_nationality = htmlspecialchars($_POST['author_nationality'] ?? '');
    $author_phone_number = htmlspecialchars($_POST['author_phone_number'] ?? '');
    $author_second_phone_number = htmlspecialchars($_POST['author_second_phone_number'] ?? '');
    $photo = $_FILES['author_picture'] ?? null;

    $updated_by = $_SESSION['user_uuid'] ?? null;

    if (!$updated_by) {
        $erreur = "Erreur d'authentification : session expirée.";
    } else {

        try {

            $checkQuery = "SELECT author_uuid 
                           FROM authors 
                           WHERE (author_email = :email OR author_phone_number = :phone)
                           AND author_uuid != :author_uuid
                           AND is_deleted = 0
                           LIMIT 1";

            $stmtCheck = $connexion->prepare($checkQuery);
            $stmtCheck->execute([
                ':email' => $author_email,
                ':phone' => $author_phone_number,
                ':author_uuid' => $author_uuid
            ]);

            if ($stmtCheck->fetch()) {

                $erreur = "Email ou téléphone déjà utilisé.";

            } else {

                $photo_name = null;
                $upload_ok = true;

                if ($photo && $photo['tmp_name']) {

                    $allowed_extensions = ['jpg','jpeg','png','gif'];
                    $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

                    if (in_array($extension,$allowed_extensions)) {

                        $photo_name = bin2hex(random_bytes(8))."_".time().".".$extension;

                        if (!move_uploaded_file($photo['tmp_name'], "../uploads/".$photo_name)) {
                            $erreur = "Échec de l'upload de la photo.";
                            $upload_ok = false;
                        }

                    } else {

                        $erreur = "Extension photo non autorisée.";
                        $upload_ok = false;

                    }
                }

                if ($upload_ok) {

                    if ($photo_name) {

                        $query = "UPDATE authors SET
                                    author_full_name = ?,
                                    author_email = ?,
                                    author_nationality = ?,
                                    author_phone_number = ?,
                                    author_second_phone_number = ?,
                                    author_picture = ?,
                                    updated_by = ?,
                                    updated_at = NOW()
                                  WHERE author_uuid = ?";

                        $stmt = $connexion->prepare($query);

                        $stmt->execute([
                            $author_full_name,
                            $author_email,
                            $author_nationality,
                            $author_phone_number,
                            $author_second_phone_number,
                            $photo_name,
                            $updated_by,
                            $author_uuid
                        ]);

                    } else {

                        $query = "UPDATE authors SET
                                    author_full_name = ?,
                                    author_email = ?,
                                    author_nationality = ?,
                                    author_phone_number = ?,
                                    author_second_phone_number = ?,
                                    updated_by = ?,
                                    updated_at = NOW()
                                  WHERE author_uuid = ?";

                        $stmt = $connexion->prepare($query);

                        $stmt->execute([
                            $author_full_name,
                            $author_email,
                            $author_nationality,
                            $author_phone_number,
                            $author_second_phone_number,
                            $updated_by,
                            $author_uuid
                        ]);
                    }

                    $success = "Auteur modifié avec succès !";
                    echo "<script>setTimeout(function() { window.location.href = 'authors.php'; }, 3000);</script>";
                }
            }

        } catch (PDOException $e) {

            $erreur = "Erreur technique : ".$e->getMessage();

        }
    }
}
?>
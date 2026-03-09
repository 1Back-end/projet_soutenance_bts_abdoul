<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");
include("../fonctions/fonction.php");

$erreur = "";
$success = "";

if (isset($_POST['submit']) && isset($_GET['user_uuid'])) {
    $user_uuid = $_GET['user_uuid']; // UUID de l'utilisateur à modifier
    $username = $_POST['username'] ?? null;
    $email = $_POST['user_email'] ?? null;
    $phone_number = $_POST['user_phone_number'] ?? null;
    $default_password = $_POST['user_password'] ?? null; // Mot de passe par défaut
    $address = $_POST['address'] ?? null;
    $updated_by = $_SESSION['user_uuid'] ?? null;

    $photo = $_FILES['user_picture'] ?? null;
    $max_image_size = 5 * 1024 * 1024; // 5 Mo
    $allowed_image_types = ['image/jpeg', 'image/png'];
    $photo_path = null;

    try {
        // Vérifier si email existe déjà pour un autre utilisateur
        $stmtCheckEmail = $connexion->prepare("SELECT COUNT(*) FROM users WHERE user_email = :email AND user_uuid != :uuid");
        $stmtCheckEmail->bindValue(':email', $email);
        $stmtCheckEmail->bindValue(':uuid', $user_uuid);
        $stmtCheckEmail->execute();
        $email_exists = $stmtCheckEmail->fetchColumn() > 0;

        // Vérifier si téléphone existe déjà pour un autre utilisateur
        $stmtCheckPhone = $connexion->prepare("SELECT COUNT(*) FROM users WHERE user_phone_number = :phone AND user_uuid != :uuid");
        $stmtCheckPhone->bindValue(':phone', $phone_number);
        $stmtCheckPhone->bindValue(':uuid', $user_uuid);
        $stmtCheckPhone->execute();
        $phone_exists = $stmtCheckPhone->fetchColumn() > 0;

        if ($email_exists) {
            $erreur = "L'email est déjà utilisé par un autre utilisateur.";
        } elseif ($phone_exists) {
            $erreur = "Le numéro de téléphone est déjà utilisé par un autre utilisateur.";
        } else {
            // Gestion de la photo
            if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
                if (!in_array($photo['type'], $allowed_image_types)) {
                    $erreur = "La photo doit être au format JPEG ou PNG.";
                } elseif ($photo['size'] > $max_image_size) {
                    $erreur = "La photo ne doit pas dépasser 5 Mo.";
                } else {
                    $photo_path = '../uploads/' . uniqid() . '-' . basename($photo['name']);
                    move_uploaded_file($photo['tmp_name'], $photo_path);
                }
            }

            if (empty($erreur)) {
                // Construction de la requête UPDATE
                $sql = "UPDATE users SET 
                            username = :username,
                            user_email = :user_email,
                            user_phone_number = :user_phone_number,
                            address = :address,
                            updated_at = NOW(),
                            updated_by = :updated_by";

                // Mettre à jour la photo si envoyée
                if ($photo_path) {
                    $sql .= ", user_picture = :user_picture";
                }

                // Mettre à jour le mot de passe si fourni
                if (!empty($default_password)) {
                    $sql .= ", user_password = :user_password";
                    $password_hash = password_hash($default_password, PASSWORD_BCRYPT);
                }

                $sql .= " WHERE user_uuid = :user_uuid";

                $stmt = $connexion->prepare($sql);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':user_email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':user_phone_number', $phone_number, PDO::PARAM_STR);
                $stmt->bindValue(':address', $address, PDO::PARAM_STR);
                $stmt->bindValue(':updated_by', $updated_by, PDO::PARAM_STR);
                $stmt->bindValue(':user_uuid', $user_uuid, PDO::PARAM_STR);

                if ($photo_path) {
                    $stmt->bindValue(':user_picture', $photo_path, PDO::PARAM_STR);
                }
                if (!empty($default_password)) {
                    $stmt->bindValue(':user_password', $password_hash, PDO::PARAM_STR);
                }

                if ($stmt->execute()) {
                    $success = "Utilisateur mis à jour avec succès !";
                    echo "<script>setTimeout(function(){ window.location.href='users.php'; }, 2000);</script>";
                } else {
                    $erreur = "Erreur lors de la mise à jour : " . implode(", ", $stmt->errorInfo());
                }
            }
        }

    } catch (PDOException $e) {
        $erreur = "Erreur serveur : " . $e->getMessage();
    }
}
ob_end_flush();
?>
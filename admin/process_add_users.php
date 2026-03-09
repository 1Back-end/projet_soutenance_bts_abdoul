<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include("../database/connexion.php");
include("../fonctions/fonction.php");

$erreur = "";
$success = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? null;
    $email = $_POST['user_email'] ?? null;
    $phone_number = $_POST['user_phone_number'] ?? null;
    $address = $_POST['address'] ?? null;
    $default_password = $_POST['user_password'] ?? null;
    $added_by = $_SESSION['user_uuid'] ?? null; // L'utilisateur qui crée ce compte

    

    if (empty($erreur)) {
        $password_hash = password_hash($default_password, PASSWORD_BCRYPT);
        $user_uuid = bin2hex(random_bytes(16));

        $photo = $_FILES['user_picture'] ?? null;
        $max_image_size = 5 * 1024 * 1024; // 5 Mo
        $allowed_image_types = ['image/jpeg', 'image/png'];
        $photo_path = null;

        try {
            // Vérifier si email existe déjà
            $stmtCheckEmail = $connexion->prepare("SELECT COUNT(*) FROM users WHERE user_email = :email");
            $stmtCheckEmail->bindValue(':email', $email);
            $stmtCheckEmail->execute();
            $email_exists = $stmtCheckEmail->fetchColumn() > 0;

            // Vérifier si téléphone existe déjà
            $stmtCheckPhone = $connexion->prepare("SELECT COUNT(*) FROM users WHERE user_phone_number = :phone");
            $stmtCheckPhone->bindValue(':phone', $phone_number);
            $stmtCheckPhone->execute();
            $phone_exists = $stmtCheckPhone->fetchColumn() > 0;

            if ($email_exists) {
                $erreur = "L'email est déjà utilisé. Veuillez en choisir un autre.";
            } elseif ($phone_exists) {
                $erreur = "Le numéro de téléphone est déjà utilisé. Veuillez en choisir un autre.";
            } else {
                // Gestion de l'image
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

                // Insertion dans la base
                if (empty($erreur)) {
                    $stmt = $connexion->prepare("
                        INSERT INTO users 
                            (user_uuid, username, user_email, user_phone_number, user_password, address, user_picture, user_role, user_status, is_new_user, counter_connection, added_by, created_at) 
                        VALUES 
                            (:user_uuid, :username, :user_email, :user_phone_number, :user_password, :address, :user_picture, 'system', 'active',1,0, :added_by, NOW())
                    ");

                    $stmt->bindValue(':user_uuid', $user_uuid, PDO::PARAM_STR);
                    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                    $stmt->bindValue(':user_email', $email, PDO::PARAM_STR);
                    $stmt->bindValue(':user_phone_number', $phone_number, PDO::PARAM_STR);
                    $stmt->bindValue(':user_password', $password_hash, PDO::PARAM_STR);
                    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
                    $stmt->bindValue(':user_picture', $photo_path, PDO::PARAM_STR);
                    $stmt->bindValue(':added_by', $added_by, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $success = "Utilisateur enregistré avec succès !";
                        echo "<script>setTimeout(function() { window.location.href = 'users.php'; }, 3000);</script>";
                    } else {
                        $erreur = "Erreur lors de l'enregistrement : " . implode(", ", $stmt->errorInfo());
                    }
                }
            }

        } catch (PDOException $e) {
            $erreur = "Erreur serveur : " . $e->getMessage();
        }
    }
}

ob_end_flush();
?>
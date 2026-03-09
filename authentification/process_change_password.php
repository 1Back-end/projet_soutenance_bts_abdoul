<?php
session_start();
include_once("../database/connexion.php");

$erreur = "";
$success = "";

// Récupérer le user_uuid depuis l'URL
$user_uuid = $_GET['user_uuid'] ?? null;

if (!$user_uuid) {
    die("Utilisateur non spécifié.");
}

if (isset($_POST['submit'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Vérifications simples
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (strlen($new_password) < 8) {
        $erreur = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
    } elseif ($new_password !== $confirm_password) {
        $erreur = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
    } else {
        // Récupérer l'utilisateur
        $stmt = $connexion->prepare("SELECT * FROM users WHERE user_uuid = :uuid AND is_deleted = 0 LIMIT 1");
        $stmt->execute([':uuid' => $user_uuid]);

        if ($stmt->rowCount() == 0) {
            $erreur = "Utilisateur introuvable.";
        } else {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier l'ancien mot de passe
            if (!password_verify($current_password, $user['user_password'])) {
                $erreur = "L'ancien mot de passe est incorrect.";
            } else {
                // Mettre à jour le mot de passe et passer is_new_user à 0
                $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

                $update = $connexion->prepare("
                    UPDATE users SET 
                        user_password = :new_password,
                        is_new_user = 0,
                        updated_at = NOW()
                    WHERE user_uuid = :uuid
                ");

                if ($update->execute([
                    ':new_password' => $new_password_hash,
                    ':uuid' => $user_uuid
                ])) {
                    $success = "Mot de passe changé avec succès ! Vous pouvez maintenant vous connecter.";
                    header("refresh:2;url=login.php");
                } else {
                    $erreur = "Erreur lors de la mise à jour du mot de passe.";
                }
            }
        }
    }
}
?>
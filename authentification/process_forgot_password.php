<?php
include_once("../database/connexion.php");

$erreur = "";
$erreur_champ = "";

if (isset($_POST["submit"])) {
    $email = $_POST["email"] ?? null;

    if (empty($email)) {
        $erreur_champ = "Veuillez entrer une adresse email.";
    } else {
        // Vérifier si l'email existe dans la base de données
        $query = $connexion->prepare("SELECT admin_uuid, username FROM admin_users WHERE email = :email AND is_deleted = 0 AND is_active = 1");
        $query->execute(['email' => $email]);
        $user = $query->fetch();

        if ($user) {
            // Rediriger vers le formulaire de réinitialisation de mot de passe
            header("Location: reset_password.php?admin_uuid=" . urlencode($user['admin_uuid']));
            exit;
        } else {
            $erreur = "Aucun utilisateur trouvé avec cet email.";
        }
    }
}
?>

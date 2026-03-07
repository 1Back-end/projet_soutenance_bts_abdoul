<?php
session_start();
include_once("../database/connexion.php");

$erreur = "";
$erreur_champ = "";

if (isset($_POST["submit"])) {
    $emailOrUsername = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($emailOrUsername) || empty($password)) {
        $erreur_champ = "Ce champ est requis !";
    } else {
        // 1. Recherche de l'utilisateur
        $query = "SELECT * FROM users WHERE (user_email = :emailOrUsername OR username = :emailOrUsername) AND is_deleted = 0 LIMIT 1";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':emailOrUsername', $emailOrUsername);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Vérification du mot de passe
            if (password_verify($password, $user['user_password'])) {
                
                // 3. Mise à jour des stats de connexion
                $updateLoginStats = "UPDATE users SET 
                                    counter_connection = IFNULL(counter_connection, 0) + 1, 
                                    last_connection_date = NOW(),
                                    first_connection_date = IFNULL(first_connection_date, NOW())
                                    WHERE user_uuid = :uuid";
                $stmtUpdate = $connexion->prepare($updateLoginStats);
                $stmtUpdate->execute([':uuid' => $user['user_uuid']]);

                // 4. Initialisation des sessions
                $_SESSION['user_uuid'] = $user['user_uuid'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['email']     = $user['user_email'];
                $_SESSION['photo']     = $user['user_picture'];
                $_SESSION['role']      = $user['user_role'];

                // 5. Gestion du "Remember Me"
                if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                    $rememberToken = bin2hex(random_bytes(32));
                    $updateToken = "UPDATE users SET remember_token = :token WHERE user_uuid = :uuid";
                    $stmtToken = $connexion->prepare($updateToken);
                    $stmtToken->execute([
                        ':token' => $rememberToken,
                        ':uuid'  => $user['user_uuid']
                    ]);
                    setcookie('remember_me', $rememberToken, time() + (86400 * 30), "/");
                }

                // 6. LOGIQUE DE REDIRECTION (Nouvel utilisateur ou non)
                if ($user['is_new_user'] == 1) {
                    // C'est sa première connexion ou il doit changer son mot de passe
                    header("Location: ../authentification/change_password.php");
                } else {
                    // Utilisateur déjà actif
                    header("Location: ../admin/dashboard.php");
                }
                exit;

            } else {
                $erreur = "Mot de passe incorrect";
            }
        } else {
            $erreur = "L'utilisateur n'existe pas ou a été supprimé";
        }
    }
}

// Vérification du cookie Remember Me
if (isset($_COOKIE['remember_me']) && !isset($_SESSION['user_uuid'])) {
    $rememberToken = $_COOKIE['remember_me'];

    $query = "SELECT * FROM users WHERE remember_token = :token AND is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute([':token' => $rememberToken]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user_uuid'] = $user['user_uuid'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['email']     = $user['user_email'];
        $_SESSION['photo']     = $user['user_picture'];
        $_SESSION['role']      = $user['user_role'];

        // Redirection intelligente même avec le cookie
        if ($user['is_new_user'] == 1) {
            header("Location: ../authentification/change_password.php");
        } else {
            header("Location: ../admin/dashboard.php");
        }
        exit;
    }
}
?>
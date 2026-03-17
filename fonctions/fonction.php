<?php
function generateUUID() {
    // Générer un UUID v4
    $data = random_bytes(16);
    // Modifier certains bits selon la spécification UUID
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant DCE 1.1
    return vsprintf('%s-%s-%s-%s-%s', str_split(bin2hex($data), 4));
}


function generatePassword($length = 12) {
    // Définir les caractères utilisés dans le mot de passe
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
    // Initialiser une variable pour stocker le mot de passe généré
    $password = '';
    
    // Boucle pour construire le mot de passe
    for ($i = 0; $i < $length; $i++) {
        // Choisir un caractère aléatoire
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $password;
}

function tousLesMois() {
    return [
        "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", 
        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
    ];
}


function generateCode($length = 4) {
    // Définir les caractères utilisables dans le code
    $characters = '0123456789'; // Chiffres et lettres majuscules
    $code = '';
    
    // Boucle pour construire le code
    for ($i = 0; $i < $length; $i++) {
        // Choisir un caractère aléatoire
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $code;
}

function getCurrentYear() {
    return date("Y"); // Renvoie l'année actuelle au format 4 chiffres (ex. 2024)
}

function getCurrentDateTime() {
    return date("d-m-Y H:i:s"); // Renvoie la date et l'heure actuelles au format "AAAA-MM-JJ HH:MM:SS"
}


include("../database/connexion.php");



// 1. Définition des paramètres
$limit = 25;
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

// 2. Fonction pour récupérer les auteurs avec LIMIT et OFFSET
function get_all_authors_paginated($connexion, $page, $limit) {
    $offset = ($page - 1) * $limit;

    $sql = "SELECT 
                a.*, 
                u1.username AS creator_name, 
                u2.username AS editor_name
            FROM authors a
            LEFT JOIN users u1 ON a.added_by = u1.user_uuid
            LEFT JOIN users u2 ON a.updated_by = u2.user_uuid
            WHERE a.is_deleted = 0
            ORDER BY a.created_at DESC
            LIMIT :limit OFFSET :offset";
            
    $requete = $connexion->prepare($sql);
    $requete->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $requete->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    $requete->execute();
    
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// 3. Calcul du total pour la pagination
$total_authors_query = $connexion->query("SELECT COUNT(*) FROM authors WHERE is_deleted = 0");
$total_authors = $total_authors_query->fetchColumn();
$total_pages = ceil($total_authors / $limit); // Nombre total de pages

// 4. Exécution de la récupération
$all_authors = get_all_authors_paginated($connexion, $current_page, $limit);



function get_all_users_paginated($connexion, $page, $limit) {

    $offset = ($page - 1) * $limit;

    $sql = "SELECT u.*, 
                   a.username AS added_by_name, 
                   e.username AS updated_by_name
            FROM users u
            LEFT JOIN users a ON u.added_by = a.user_uuid
            LEFT JOIN users e ON u.updated_by = e.user_uuid
            WHERE u.is_deleted = 0
            ORDER BY u.created_at DESC
            LIMIT :limit OFFSET :offset";

    $requete = $connexion->prepare($sql);

    $requete->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $requete->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

    $requete->execute();

    return $requete->fetchAll(PDO::FETCH_ASSOC);
}
$total_users_query = $connexion->query("SELECT COUNT(*) FROM users WHERE is_deleted = 0");

$total_users = $total_users_query->fetchColumn();

$total_pages = ceil($total_users / $limit);
$all_users = get_all_users_paginated($connexion, $current_page, $limit);



// 2. Fonction pour récupérer les auteurs avec LIMIT et OFFSET
function get_all_category_paginated($connexion, $page, $limit) {
    $offset = ($page - 1) * $limit;

    $sql = "SELECT 
                c.*, 
                u1.username AS creator_name, 
                u2.username AS editor_name
            FROM category_books c
            LEFT JOIN users u1 ON c.added_by = u1.user_uuid
            LEFT JOIN users u2 ON c.updated_by = u2.user_uuid
            WHERE c.is_deleted = 0
            ORDER BY c.created_at DESC
            LIMIT :limit OFFSET :offset";
            
    $requete = $connexion->prepare($sql);
    $requete->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $requete->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    $requete->execute();
    
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// 3. Calcul du total pour la pagination
$total_category_books_query = $connexion->query("SELECT COUNT(*) FROM category_books WHERE is_deleted = 0");
$total_category_books = $total_category_books_query->fetchColumn();
$total_pages = ceil($total_category_books / $limit); // Nombre total de pages

// 4. Exécution de la récupération
$all_category_books = get_all_category_paginated($connexion, $current_page, $limit);


function get_all_active_genres($connexion) {
    // On filtre sur is_active = 1 (ou true)
    $requete = $connexion->prepare("SELECT * FROM genre_books WHERE is_active = 1 ORDER BY genre_name ASC");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// Utilisation
$all_genres_active = get_all_active_genres($connexion);


function get_all_active_categories($connexion){
    // On filtre pour ne prendre que les catégories actives et non supprimées
    $requete = $connexion->prepare("SELECT * FROM category_books WHERE is_active = 1 AND is_deleted = 0 ORDER BY category_name ASC");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// Appel de la fonction
$all_categories_active = get_all_active_categories($connexion);


function get_all_active_authors($connexion){
    // On sélectionne les auteurs actifs (is_active = 1) et non supprimés (is_deleted = 0)
    $requete = $connexion->prepare("SELECT * FROM authors WHERE is_active = 1 AND is_deleted = 0 ORDER BY author_full_name ASC");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

// Appel de la fonction pour alimenter votre formulaire
$all_authors_active = get_all_active_authors($connexion);

function get_years() {
    $current_year = date('Y'); // Année actuelle
    $years = [];
    
    // Générer les années de 1960 jusqu'à l'année actuelle
    for ($year = 1960; $year <= $current_year; $year++) {
        $years[] = $year;
    }

    return $years;
}
// Exemple d'utilisation
$years = get_years();





// Fonction pour récupérer les livres avec pagination
function get_all_books_paginated($connexion, $page, $limit) {
    try {
       $offset = ($page - 1) * $limit;

       $query = "SELECT 
            b.*, 
            c.category_name, 
            g.genre_name, 
            a.author_full_name, 
            u_added.username AS created_by, 
            u_updated.username AS updated_by
          FROM books b
          INNER JOIN category_books c ON b.category_uuid = c.category_uuid
          INNER JOIN genre_books g ON b.genre_uuid = g.genre_uuid
          INNER JOIN authors a ON b.author_uuid = a.author_uuid
          LEFT JOIN users u_added ON b.added_by = u_added.user_uuid
          LEFT JOIN users u_updated ON b.updated_by = u_updated.user_uuid
          WHERE b.is_deleted = 0
          ORDER BY b.created_at DESC
          LIMIT :limit OFFSET :offset";

        $stmt = $connexion->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // En production, il vaut mieux logger l'erreur que de l'afficher
        error_log("Erreur SQL : " . $e->getMessage());
        return [];
    }
}

$total_books_query = $connexion->query("SELECT COUNT(*) FROM books WHERE is_deleted = 0");
$total_books = $total_books_query->fetchColumn();
$total_pages = ceil($total_books / $limit);

// 2. Récupération des livres avec la fonction corrigée
$all_books = get_all_books_paginated($connexion, $current_page, $limit);

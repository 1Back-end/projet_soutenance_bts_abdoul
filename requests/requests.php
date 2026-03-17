
<?php
include("../database/connexion.php");



// 1. Définition des paramètres
$limit = 25;
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;


// Fonction pour récupérer les livres avec pagination
function get_all_books_paginated($connexion, $page, $limit) {
    try {
       $offset = ($page - 1) * $limit;

       $query = "SELECT 
            b.*, 
            c.category_name, 
            g.genre_name, 
            a.author_full_name,
            a.author_picture,
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

<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit'])) {

    $book_name = htmlspecialchars(trim($_POST['book_name']));
    $category_uuid = htmlspecialchars($_POST['category_uuid']);
    $genre_uuid = htmlspecialchars($_POST['genre_uuid']);
    $author_uuid = htmlspecialchars($_POST['author_uuid']);
    $book_publication_date = htmlspecialchars($_POST['book_publication_date']);
    $book_isbn = htmlspecialchars(trim($_POST['book_isbn']));
    $book_description = htmlspecialchars(trim($_POST['book_description']));
    $book_location = htmlspecialchars(trim($_POST['book_location']));
    $book_copies = intval($_POST['book_copies']);
    $added_by = $_SESSION['user_uuid'] ?? null;

    if (!$added_by) {
        $erreur = "Session expirée. Veuillez vous reconnecter.";
    } elseif (empty($book_name) || empty($category_uuid) || empty($genre_uuid) || empty($author_uuid) || empty($book_publication_date) || empty($book_isbn) || empty($_FILES['book_picture']['name'])) {
        $erreur = "Tous les champs obligatoires doivent être remplis !";
    } else {

        try {
            // Gestion du fichier image
            $uploadDir = "../uploads/";
            $book_picture = null;
            if (!empty($_FILES['book_picture']['name'])) {
                $fileName = basename($_FILES['book_picture']['name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = ['jpg','jpeg','png','gif'];

                if (!in_array($fileExt, $allowed)) {
                    $erreur = "Type d'image non autorisé !";
                } else {
                    $newFileName = uniqid('book_').'.'.$fileExt;
                    $targetFile = $uploadDir . $newFileName;
                    if (move_uploaded_file($_FILES['book_picture']['tmp_name'], $targetFile)) {
                        $book_picture = $newFileName;
                    } else {
                        $erreur = "Erreur lors de l'upload de l'image.";
                    }
                }
            }

            if (empty($erreur)) {

                // Fonction pour générer un code unique
                function generateBookCode($book_name, $year) {
                    $prefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $book_name), 0, 3));
                    $random = rand(1000, 9999);
                    return $prefix . '_' . $year . '_' . $random;
                }

                // Vérifier si ISBN existe
                $stmtCheck = $connexion->prepare("SELECT book_uuid FROM books WHERE book_isbn = :isbn AND is_deleted = 0 LIMIT 1");
                $stmtCheck->execute([':isbn' => $book_isbn]);

                if ($stmtCheck->fetch()) {
                    $erreur = "Un livre avec ce ISBN existe déjà !";
                } else {

                    // Générer code unique et vérifier qu'il n'existe pas
                    do {
                        $book_code = generateBookCode($book_name, $book_publication_date);
                        $stmtCode = $connexion->prepare("SELECT book_uuid FROM books WHERE book_code = :code LIMIT 1");
                        $stmtCode->execute([':code' => $book_code]);
                        $exists = $stmtCode->fetch();
                    } while ($exists);

                    $book_uuid = bin2hex(random_bytes(16));

                    $stmtInsert = $connexion->prepare("INSERT INTO books (
                        book_uuid, category_uuid, genre_uuid, author_uuid, book_name, book_publication_date, book_isbn, 
                        book_description, book_picture, book_copies, book_location, book_code, added_by, created_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

                    $stmtInsert->execute([
                        $book_uuid,
                        $category_uuid,
                        $genre_uuid,
                        $author_uuid,
                        $book_name,
                        $book_publication_date,
                        $book_isbn,
                        $book_description,
                        $book_picture,
                        $book_copies,
                        $book_location,
                        $book_code,
                        $added_by
                    ]);

                    $success = "Livre enregistré avec succès ! Code du livre : $book_code";
                    echo "<script>setTimeout(function() { window.location.href = 'books.php'; }, 3000);</script>";
                }
            }

        } catch (PDOException $e) {
            $erreur = "Erreur technique : " . $e->getMessage();
        }
    }
}
?>
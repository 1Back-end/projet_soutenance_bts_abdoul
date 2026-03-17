<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include("../database/connexion.php");

$erreur = "";
$success = "";

if (isset($_POST['submit'])) {

    $book_uuid = $_POST['book_uuid'];
    $book_name = htmlspecialchars(trim($_POST['book_name']));
    $category_uuid = htmlspecialchars($_POST['category_uuid']);
    $genre_uuid = htmlspecialchars($_POST['genre_uuid']);
    $author_uuid = htmlspecialchars($_POST['author_uuid']);
    $book_publication_date = htmlspecialchars($_POST['book_publication_date']);
    $book_isbn = htmlspecialchars(trim($_POST['book_isbn']));
    $book_description = htmlspecialchars(trim($_POST['book_description']));
    $book_location = htmlspecialchars(trim($_POST['book_location']));
    $book_copies = intval($_POST['book_copies']);
    $updated_by = $_SESSION['user_uuid'] ?? null;

    if (!$updated_by) {
        $erreur = "Session expirée. Veuillez vous reconnecter.";
    } elseif (empty($book_name) || empty($category_uuid) || empty($genre_uuid) || empty($author_uuid) || empty($book_publication_date) || empty($book_isbn)) {
        $erreur = "Tous les champs obligatoires doivent être remplis !";
    } else {

        try {
            // Récupérer l'image actuelle
            $stmtOld = $connexion->prepare("SELECT book_picture FROM books WHERE book_uuid = :book_uuid LIMIT 1");
            $stmtOld->execute([':book_uuid' => $book_uuid]);
            $oldBook = $stmtOld->fetch(PDO::FETCH_ASSOC);
            $currentPicture = $oldBook['book_picture'] ?? null;

            // Gestion du fichier image
            $book_picture = $currentPicture;
            if (!empty($_FILES['book_picture']['name'])) {
                $uploadDir = "../uploads/";
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
                        // Optionnel : supprimer l'ancienne image
                        if ($currentPicture && file_exists($uploadDir.$currentPicture)) {
                            unlink($uploadDir.$currentPicture);
                        }
                    } else {
                        $erreur = "Erreur lors de l'upload de l'image.";
                    }
                }
            }

            if (empty($erreur)) {

                // Vérifier si ISBN existe pour un autre livre
                $stmtCheck = $connexion->prepare("SELECT book_uuid FROM books WHERE book_isbn = :isbn AND book_uuid != :book_uuid AND is_deleted = 0 LIMIT 1");
                $stmtCheck->execute([':isbn' => $book_isbn, ':book_uuid' => $book_uuid]);

                if ($stmtCheck->fetch()) {
                    $erreur = "Un autre livre avec ce ISBN existe déjà !";
                } else {

                    // Mise à jour du livre
                    $stmtUpdate = $connexion->prepare("UPDATE books SET 
                        book_name = :book_name,
                        category_uuid = :category_uuid,
                        genre_uuid = :genre_uuid,
                        author_uuid = :author_uuid,
                        book_publication_date = :book_publication_date,
                        book_isbn = :book_isbn,
                        book_description = :book_description,
                        book_location = :book_location,
                        book_copies = :book_copies,
                        book_picture = :book_picture,
                        updated_by = :updated_by,
                        updated_at = NOW()
                        WHERE book_uuid = :book_uuid
                        LIMIT 1");

                    $stmtUpdate->execute([
                        ':book_name' => $book_name,
                        ':category_uuid' => $category_uuid,
                        ':genre_uuid' => $genre_uuid,
                        ':author_uuid' => $author_uuid,
                        ':book_publication_date' => $book_publication_date,
                        ':book_isbn' => $book_isbn,
                        ':book_description' => $book_description,
                        ':book_location' => $book_location,
                        ':book_copies' => $book_copies,
                        ':book_picture' => $book_picture,
                        ':updated_by' => $updated_by,
                        ':book_uuid' => $book_uuid
                    ]);

                    $success = "Livre mis à jour avec succès !";
                    echo "<script>setTimeout(function() { window.location.href = 'books.php'; }, 3000);</script>";
                }
            }

        } catch (PDOException $e) {
            $erreur = "Erreur technique : " . $e->getMessage();
        }
    }
}

if (!empty($erreur)) {
    header('Location: edit_book.php?book_uuid=' . urlencode($book_uuid) . '&message=' . urlencode($erreur) . '&type=danger');
    exit();
}
?>
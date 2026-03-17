<?php include("../include/menu.php"); ?>
<?php include("../fonctions/fonction.php"); ?>
<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include("../database/connexion.php");

// Vérification de la présence du book_uuid
if (!isset($_GET['book_uuid'])) {
    header('Location: books.php?message=' . urlencode('Livre non spécifié.') . '&type=warning');
    exit();
}

$book_uuid = $_GET['book_uuid'];

try {
    // Récupération du livre avec jointures
    $sql = "SELECT 
                b.*,
                c.category_name,
                c.category_uuid,
                g.genre_name,
                g.genre_uuid,
                a.author_full_name,
                a.author_uuid
            FROM books b
            JOIN category_books c ON b.category_uuid = c.category_uuid
            JOIN genre_books g ON b.genre_uuid = g.genre_uuid
            JOIN authors a ON b.author_uuid = a.author_uuid
            WHERE b.book_uuid = :book_uuid
              AND b.is_deleted = 0
            LIMIT 1";

    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':book_uuid', $book_uuid, PDO::PARAM_STR);
    $stmt->execute();
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        header('Location: books.php?message=' . urlencode('Livre non trouvé.') . '&type=warning');
        exit();
    }

    // Récupération des catégories, genres et auteurs actifs
    $all_categories_active = $connexion->query("SELECT * FROM category_books WHERE is_active = 1 AND is_deleted = 0")->fetchAll(PDO::FETCH_ASSOC);
    $all_genres_active = $connexion->query("SELECT * FROM genre_books WHERE is_active = 1 AND is_deleted = 0")->fetchAll(PDO::FETCH_ASSOC);
    $all_authors_active = $connexion->query("SELECT * FROM authors WHERE is_active = 1 AND is_deleted = 0")->fetchAll(PDO::FETCH_ASSOC);

    // Préparer les années pour la sélection
    $current_year = (int)date('Y');
    $years = range($current_year, 1900); // De l'année actuelle jusqu'à 1900

} catch (PDOException $e) {
    die("Erreur lors de la récupération du livre : " . $e->getMessage());
}
?>

<link rel="stylesheet" href="style.css">
<div class="main-container pb-5 mt-3">
    <div class="col-md-12 col-sm-12">
        <div class="card shadow p-4 border rounded">

            <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row gap-2 mb-4">
                <h4 class="h3 mb-0 text-gray-800 text-uppercase fw-bold mt-2">
                    Modifier le livre
                </h4>
                <span>
                    <?php include("process_edit_books.php") ?>

                    <?php if (!empty($erreur)) : ?>
                        <span id="error-message" class="text-danger fw-bold">
                            <?= $erreur ?>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($success)) : ?>
                        <span id="success-message" class="text-success fw-bold">
                            <?= $success ?>
                        </span>
                    <?php endif; ?>
                </span>
            </div>


            <!-- Formulaire -->
            <form class="needs-validation" novalidate method="POST" enctype="multipart/form-data">
                <input type="hidden" name="book_uuid" value="<?= htmlspecialchars($book['book_uuid']) ?>">

                <div class="row g-3">

                    <!-- Titre -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_name">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" required id="book_name" name="book_name"
                               value="<?= htmlspecialchars($book['book_name']) ?>">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Catégorie -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="category_uuid">Catégorie <span class="text-danger">*</span></label>
                        <select name="category_uuid" class="custom-select shadow-none ps-3" required id="category_uuid">
                            <option disabled value="">Choisir une option</option>
                            <?php foreach ($all_categories_active as $category): ?>
                                <option value="<?= htmlspecialchars($category['category_uuid']) ?>"
                                    <?= ($category['category_uuid'] == $book['category_uuid']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['category_name']) ?> (<?= htmlspecialchars($category['category_code']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Genre -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="genre_uuid">Genre <span class="text-danger">*</span></label>
                        <select name="genre_uuid" class="custom-select shadow-none ps-3" required id="genre_uuid">
                            <option disabled value="">Choisir une option</option>
                            <?php foreach ($all_genres_active as $genre): ?>
                                <option value="<?= htmlspecialchars($genre['genre_uuid']) ?>"
                                    <?= ($genre['genre_uuid'] == $book['genre_uuid']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($genre['genre_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Auteur -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="author_uuid">Auteur <span class="text-danger">*</span></label>
                        <select name="author_uuid" class="custom-select shadow-none ps-3" required id="author_uuid">
                            <option disabled value="">Choisir une option</option>
                            <?php foreach($all_authors_active as $author_item): ?>
                                <option value="<?= htmlspecialchars($author_item['author_uuid']) ?>"
                                    <?= ($author_item['author_uuid'] == $book['author_uuid']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($author_item['author_full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Année publication -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_publication_date">Année publication <span class="text-danger">*</span></label>
                        <select name="book_publication_date" class="custom-select shadow-none ps-3" required id="book_publication_date">
                            <option disabled value="">Choisir une option</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= ($year == $book['book_publication_date']) ? 'selected' : '' ?>>
                                    <?= $year ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- ISBN -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_isbn">ISBN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" required id="book_isbn" name="book_isbn"
                               value="<?= htmlspecialchars($book['book_isbn']) ?>">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Nombre d’exemplaires -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_copies">Nombre d’exemplaires <span class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control shadow-none" required id="book_copies" name="book_copies"
                               value="<?= htmlspecialchars($book['book_copies']) ?>">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Emplacement -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_location">Emplacement <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" required id="book_location" name="book_location"
                               placeholder="Ex: Salle A - Rayon 3"
                               value="<?= htmlspecialchars($book['book_location']) ?>">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Image -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_picture">Image</label>
                        <?php if (!empty($book['book_picture'])): ?>
                            <img src="../uploads/<?= htmlspecialchars($book['book_picture']) ?>" alt="Livre" class="img-thumbnail mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                        <?php endif; ?>
                        <input type="file" class="form-control-file shadow-none d-block" id="book_picture" name="book_picture">
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="book_description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control shadow-none" style="height: 90px;" id="book_description" name="book_description" required><?= htmlspecialchars($book['book_description']) ?></textarea>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" name="submit" class="btn btn-primary shadow-none">Modifier le livre</button>
                    <a href="books.php" class="btn btn-secondary shadow-none mx-2">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script src="script.js"></script>
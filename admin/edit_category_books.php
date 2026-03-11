<?php include("../include/menu.php"); ?>

<?php
include("../database/connexion.php");

if (!isset($_GET['category_uuid'])) {
    header('Location: category_books.php?message=' . urlencode('Catégorie non spécifiée.') . '&type=warning');
    exit();
}

$category_uuid = $_GET['category_books_uuid'];

$sql = "SELECT * FROM category_books 
        WHERE category_books_uuid = :category_books_uuid 
        AND is_deleted = 0 
        LIMIT 1";

$stmt = $connexion->prepare($sql);
$stmt->bindParam(':category_books_uuid', $category_books_uuid, PDO::PARAM_STR);
$stmt->execute();

$category_books = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    header('Location: category_books.php?message=' . urlencode('Catégorie non trouvée.') . '&type=warning');
    exit();
}
?>
<div class="main-container pb-5 mt-3">
    <div class="col-md-12 col-sm-12 mb-3">
        <?php include("process_edit_category_books.php") ?>  

        <?php if (!empty($erreur)) : ?>
            <div id="error-message" class="alert alert-danger text-center border-0" role="alert">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <div id="success-message" class="alert alert-success text-center border-0" role="alert">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card shadow p-4 border rounded">

            <div class="d-flex justify-content-between gap-2 flex-column flex-lg-row">
                <h4 class="h3 mb-0 text-gray-800 text-uppercase fw-bold mt-2">Modifier une catégorie de livres</h4>
            </div>

            <form class="needs-validation" novalidate action="" method="post" enctype="multipart/form-data">
                <div class="row mt-3">
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label for="category_books_name" class="form-label">Nom de la catégorie <span class="text-danger fs-5">*</span></label>
                            <input type="text" required class="form-control form-control-lg" id="category_books_name" name="category_books_name"
                            value="<?= htmlspecialchars($category['category_books_name']) ?>">
                            <div class="invalid-feedback">
                                Ce champ est requis !
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="category_books_description" class="form-label">Description</label>
                            <textarea class="form-control form-control-lg" id="category_description" name="category_books_description" rows="4"><?= htmlspecialchars($category['category_books_description']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label for="category_status" class="form-label">Statut</label>
                            <select class="form-select form-select-lg" id="category_books_is_active" name="category_books_is_active">
                                <option value="1" <?= ($category_books['is_active'] == 1) ? 'selected' : '' ?>>Actif</option>
                                <option value="0" <?= ($category_books['is_active'] == 0) ? 'selected' : '' ?>>Inactif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category_books_image" class="form-label">Image de la catégorie</label>
                            <input type="file" class="form-control form-control-lg" id="category_books_image" name="category_books_image" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary shadow-none px-4">
                        Modifier
                    </button>
                    <a href="category_books.php" class="btn btn-secondary shadow-none px-4 mx-2">
                        Retour
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
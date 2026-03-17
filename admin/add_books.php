<?php include("../include/menu.php"); ?>
<?php include("../fonctions/fonction.php"); ?>
<link rel="stylesheet" href="style.css">
<div class="main-container pb-5 mt-3">
    <div class="col-md-12 col-sm-12">
        <div class="card shadow p-4 border rounded">

            <!-- Titre + messages -->
            <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row gap-2 mb-4">
                <h4 class="h3 mb-0 text-gray-800 text-uppercase fw-bold mt-2">
                    Ajouter un livre
                </h4>
                <span>
                    <?php include("process_add_books.php") ?>

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
            <form class="needs-validation" novalidate action="" method="POST" enctype="multipart/form-data">
                <div class="row g-3">

                    <!-- Titre -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_name">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" required id="book_name" name="book_name">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Catégorie -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="category_uuid">Catégorie <span class="text-danger">*</span></label>
                        <select name="category_uuid" class="custom-select shadow-none ps-3" required id="category_uuid">
                            <option disabled selected value="">Choisir une option</option>
                            <?php foreach ($all_categories_active as $category): ?>
                                <option value="<?= htmlspecialchars($category['category_uuid']) ?>">
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
                            <option selected disabled value="">Choisir une option</option>
                            <?php foreach ($all_genres_active as $genre): ?>
                                <option value="<?= htmlspecialchars($genre['genre_uuid']) ?>">
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
                            <option disabled selected value="">Choisir une option</option>
                            <?php foreach($all_authors_active as $author): ?>
                                <option value="<?= htmlspecialchars($author['author_uuid']) ?>">
                                    <?= htmlspecialchars($author['author_full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Année publication -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_publication_date">Année publication <span class="text-danger">*</span></label>
                        <select name="book_publication_date" class="custom-select shadow-none ps-3" required id="book_publication_date">
                            <option disabled selected value="">Choisir une option</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- ISBN -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_isbn">ISBN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" required id="book_isbn" name="book_isbn">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Nombre d’exemplaires -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_copies">Nombre d’exemplaires <span class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control shadow-none" required id="book_copies" name="book_copies">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Emplacement -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_location">Emplacement <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" required id="book_location" name="book_location" placeholder="Ex: Salle A - Rayon 3">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Image -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label for="book_picture">Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control-file shadow-none d-block" required id="book_picture" name="book_picture">
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                    <!-- Description (plein largeur) -->
                    <div class="col-12">
                        <label for="book_description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control shadow-none" required style="height: 90px;" id="book_description" name="book_description"></textarea>
                        <div class="invalid-feedback">Ce champ est requis !</div>
                    </div>

                </div>

                <!-- Boutons -->
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" name="submit" class="btn btn-primary shadow-none">
                        Enregistrer le livre
                    </button>
                    <a href="books.php" class="btn btn-secondary shadow-none mx-2">
                        Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script src="script.js"></script>
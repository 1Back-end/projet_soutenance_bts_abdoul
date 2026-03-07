<?php include("../include/menu.php"); ?>
<link rel="stylesheet" href="style.css">

<div class="main-container pb-5 mt-3">
    <div class="col-md-12 col-sm-12 mb-3">
        <?php include("process_add_authors.php") ?>  

    <?php if (!empty($erreur)) : ?>
        <div id="error-message" class="alert alert-danger text-center border-0" role="alert">
            <?= $erreur ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <div id="success-message" class="alert alert-success text-center border-0" role="alert">
            <?= $success ?>
        </div>
    <?php endif; ?>

    </div>

    <div class="col-md-12 col-sm-12 mb-3">
    <div class="card shadow p-4 border rounded">

    <div class="d-flex justify-content-between gap-2 flex-column flex-lg-row">
        <h4 class="h3 mb-0 text-gray-800 text-uppercase fw-bold mt-2">Ajouter un auteur</h4>
    </div>

        <form class="needs-validation" novalidate action="" method="post" enctype="multipart/form-data">
            <div class="row mt-3">
                <div class="col-lg-6 col-sm-12 mb-3">
                    <div class="mb-3">
                        <label for="author_full_name" class="form-label">Nom complet <span class="text-danger fs-5">*</span></label>
                        <input type="text" required class="form-control form-control-lg" id="author_full_name" name="author_full_name">
                        <div class="invalid-feedback">
                            Ce champ est requis !
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="author_email" class="form-label">Email <span class="text-danger fs-5">*</span></label>
                        <input type="email" class="form-control ps-2 py-3 form-control-lg" required id="author_email" name="author_email">
                        <div class="invalid-feedback">
                            Ce champ est requis !
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="author_nationality" class="form-label">Nationalité <span class="text-danger fs-5">*</span></label>
                        <input type="text" class="form-control ps-2 py-3 form-control-lg" required id="author_nationality" name="author_nationality">
                        <div class="invalid-feedback">
                            Ce champ est requis !
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12 mb-3">
                    <div class="mb-3">
                        <label for="author_phone_number" class="form-label">Numéro de téléphone <span class="text-danger fs-5">*</span></label>
                        <input type="tel" class="form-control ps-2 py-3 form-control-lg" required id="author_phone_number" name="author_phone_number">
                        <div class="invalid-feedback">
                            Ce champ est requis !
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="author_second_phone_number" class="form-label">Numéro de téléphone secondaire</label>
                        <input type="tel" class="form-control ps-2 py-3 form-control-lg" id="author_second_phone_number" name="author_second_phone_number">
                    </div>
                    <div class="mb-3">
                        <label for="author_picture" class="form-label">Photo de profil</label>
                        <input type="file" class="form-control form-control-lg" id="author_picture" name="author_picture" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
            <button type="submit" name="submit" class="btn btn-primary shadow-none px-4">
                Enregistrer
            </button>
            <a href="authors.php" class="btn btn-secondary shadow-none px-4 mx-2">
                Retour
            </a>
        
        </div>
        </form>
    </div>
</div>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script src="script.js"></script>
<?php include_once('../include/menu.php');?>

<?php
include("../database/connexion.php");

if (!isset($_GET['user_uuid'])) {
    header('Location: users.php?message=' . urlencode('User non spécifié.') . '&type=warning');
    exit();
}

$user_uuid = $_GET['user_uuid'];

$sql = "SELECT * FROM users 
        WHERE user_uuid = :user_uuid 
        AND is_deleted = 0 
        LIMIT 1";

$stmt = $connexion->prepare($sql);
$stmt->bindParam(':user_uuid', $user_uuid, PDO::PARAM_STR);
$stmt->execute();

$author = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$author) {
    header('Location: users.php?message=' . urlencode('User non trouvé.') . '&type=warning');
    exit();
}
?>
<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <?php include("process_edit_users.php"); ?>  

        <?php if (!empty($erreur)): ?>
            <div id="error-message" class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div id="success-message" class="alert alert-success text-center" role="alert">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between gap-2 flex-column flex-lg-row">
                <h4 class="h3 mb-0 text-gray-800 text-uppercase fw-bold mt-2">Modifier l'utilisateur</h4>
            </div>

            <form class="needs-validation" novalidate action="" method="post" enctype="multipart/form-data">
                <div class="row mt-4">

                    <!-- Colonne gauche -->
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label for="username">Nom Complet <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" required name="username" id="username"
                                value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : htmlspecialchars($author['username']) ?>">
                            <div class="invalid-feedback">
                                Ce champ est requis !
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="user_email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg" required name="user_email" id="user_email"
                                value="<?= isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : htmlspecialchars($author['user_email']) ?>">
                            <div class="invalid-feedback">
                                Ce champ est requis !
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Adresse <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" required name="address" id="address"
                                value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : htmlspecialchars($author['address']) ?>">
                            <div class="invalid-feedback">
                                Ce champ est requis !
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="col-lg-6 col-sm-12 mb-3">
                        <div class="mb-3">
                            <label for="user_phone_number">Numéro de téléphone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg" required name="user_phone_number" id="user_phone_number"
                                value="<?= isset($_POST['user_phone_number']) ? htmlspecialchars($_POST['user_phone_number']) : htmlspecialchars($author['user_phone_number']) ?>">
                            <div class="invalid-feedback">
                                Ce champ est requis !
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="user_picture">Photo de profil</label>
                            <input type="file" name="user_picture" id="user_picture" class="form-control shadow-none">
                            <?php if (!empty($author['user_picture'])): ?>
                                <img src="<?= htmlspecialchars($author['user_picture']) ?>" alt="Photo profil" class="img-thumbnail mt-2" style="width:80px;height:80px;object-fit:cover;">
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="user_password">Mot de passe par défaut (MotDePasse123)</label>
                            <input type="password" class="form-control form-control-lg" id="user_password" name="user_password" 
                                value="<?= isset($default_password) ? htmlspecialchars($default_password) : 'MotDePasse123' ?>" readonly>
                            <small class="text-muted">Ce mot de passe sera utilisé par défaut pour l'utilisateur.</small>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex gap-2">
                    <button type="submit" name="submit" class="btn btn-primary shadow-none">Modifier</button>
                    <a href="users.php" class="btn btn-secondary shadow-none mx-2">Retour</a>
                </div>

            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

<script src="script.js"></script>
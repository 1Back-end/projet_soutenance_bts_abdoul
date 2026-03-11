<?php include("../include/menu.php"); ?>

<?php 
include("../database/connexion.php");
if (isset ($_GET["uuid"])) {
    $uuid = $_GET["uuid"];
    $query = "SELECT * FROM tlbl_category_books WHERE uuid = :uuid";
    $execute_request = $connexion->prepare($query);
    $execute_request->bindParam(":uuid", $uuid);
    $execute_request->execute();
    $category_product = $execute_request->fetch(PDO::FETCH_ASSOC);

}else{
    header("Location: category_books.php?message=uuid du category_books introuvable");
    exit;
}


?>

<div class="container mt-5 py-5 pb-5">
<div class="col-lg-12 col-sm-12">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold text-uppercase text-primary mb-0">Modifier une categorie de livre</h4>
        <a href="category_books.php" class="btn btn-secondary border-0 rounded-0">
           <i class="fa-solid fa-backward me-1"></i>
            Annuler

        </a>
    </div>


    <div class="col-md-12 col-sm-12 mb-3">
    <?php include("process_update_category_books.php"); ?>
    <?php if ($error): ?>
    <div class="alert alert-danger text-center border-0 rounded-0"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success text-center border-0 rounded-0"><?= $success ?></div>
    <?php endif;?>
</div>

<div class="col-lg-12 col-sm-12">
    <div class="card shadow mt-3 border-0 rounded-0 p-3">
        <form class="needs-validation" novalidate action="" method="post">
            <div class="row">


                <div class="col-lg-4 col-sm-12 mb-3">
                    <label for="">Name <span class="text-danger">*</span></label>
                    <input type="text" value="<?= $category_product["name"]?>"   name="name" class="form-control" required>
                    <input type="hidden" value="<?= $category_product["uuid"]?>"   name="uuid" class="form-control" required>
                    <div class="invalid-feedback">
                        ce champ est requis
                    </div>
                </div>


                <div class="col-lg-4 col-sm-12 mb-3">
                    <label for="">Description <span class="text-danger">*</span></label>
                    <input type="text" value="<?= $category_product["description"]?>" name="description" class="form-control">
                    <div class="invalid-feedback">
                        ce champ est requis
                    </div>
                </div>


            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" name="update_category_books" class="btn btn-primary border-0 rounded-0 mt-3">modifier</button>
                <button type="reset" class="btn btn-danger border-0 rounded-0">cancel</button>
            </div>

        </form>
    </div>
</div>




</div>





</div>

<script src="../assets/js/main.js"></script>
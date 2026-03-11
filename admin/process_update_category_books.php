<?php
include("../database/connexion.php");
include("../fonctions/fonction.php");


$error = "";
$success = "";


if(isset($_POST["update_category_books"])){
    $uuid = $_POST["uuid"] ?? null;
    $name  = $_POST["name"] ?? null;
    $description = $_POST["description"] ?? null;


    // Verifications de l'uncité des données

    $exists_info = $connexion->prepare("SELECT COUNT(*) FROM tlbl_category_books WHERE is_deleted = 1 AND  (name = :name)");
    $exists_info->execute([
        ":name" => $name,
    ]);
    if($exists_info->fetchColumn() > 0){
        $error = "Cette categorie de livre existe dejà !";
    }else {
        $update_info = $connexion->prepare(query: "UPDATE tlbl_category_books SET name = :name ,description = :description WHERE uuid = :uuid"); 

        $update_info->execute([
        ':uuid'    => $uuid,
        ':name'    => $name,
        ':description'  => $description,
        ]);


        if ($update_info) {
            $success ="category_books modifié avec succès";
            
        }else {
            $error = "Erreur lors de la modification du category_books !";
        }

        
    }

}



?>
<?php include("../include/menu.php"); ?>
<?php include("../fonctions/fonction.php"); ?>
<div class="main-container pb-5 mt-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="h3 mb-0 text-gray-800 text-uppercase fw-bold">Liste des livres</h3>
            </div>
            <div class="ml-auto">
                <a href="add_books.php" class="btn shadow-none btn-primary fw-bold">
                    <i class="fas fa-plus-circle"></i> Ajouter un nouveau
                </a>
            </div>
        </div>
    </div>


<div class="col-md-12 col-sm-12 mb-3">
    <div class="card shadow-sm border-0 p-3">
           <div class="col-md-6 col-sm-12 mb-3">
                <?php if (!empty($_GET["message"])) : ?>
                    <?php $message = $_GET["message"]; ?>
                        <span class="text-success fw-bold">
                            <i class="fas fa-check-circle me-1"></i> <?php echo htmlspecialchars($message); ?> !
                        </span>
                <?php endif; ?>
            </div>

        <div class="table-responsive">
    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Catégorie</th>
                <th>Genre</th>
                <th>ISBN</th>
                <th>Status</th>
                <th>Créer le</th>
                <th>Dernière modif.</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($all_books)): ?>
                <?php foreach ($all_books as $index => $book): ?>
                    <tr>
                        <td><?= $index + 1 + (($current_page - 1) * $limit) ?></td>
                        <td>
                            <?php if (!empty($book['book_picture'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($book['book_picture']) ?>" alt="Livre" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            <?php else: ?>
                                <span>Aucune image</span>
                            <?php endif; ?>
                        </td>
                       <td>
                            <?= htmlspecialchars($book['book_name']) ?>
                            <div class="text-muted" style="font-size: 0.8rem;">
                                <?= htmlspecialchars($book['book_code']) ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($book['author_full_name']) ?></td>
                        <td><?= htmlspecialchars($book['category_name']) ?></td>
                        <td><?= htmlspecialchars($book['genre_name']) ?></td>
                        <td><?= htmlspecialchars($book['book_isbn']) ?></td>
                        <td>
                            <?php if ($book['is_active']): ?>
                                <span class="badge bg-success text-white py-2 px-2">Actif</span>
                            <?php else: ?>
                                <span class="badge bg-danger text-white py-2 px-2">Inactif</span>
                            <?php endif; ?>
                        </td>
                        <td><?= !empty($book['created_by']) ? htmlspecialchars($book['created_by']) : '' ?> <br> <?= $book['created_at'] ?? '' ?></td>
                        <td><?= !empty($book['updated_by']) ? htmlspecialchars($book['updated_by']) : '' ?> <br> <?= $book['updated_at'] ?? '' ?></td>

                        <td>
                         <div class="dropdown">
                                    <button class="btn shadow-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu p-2 shadow-lg">
                                <!-- Modifier le livre -->
                                <a class="btn btn-outline-warning d-flex align-items-center w-100 mb-2"
                                href="edit_book.php?book_uuid=<?= $book['book_uuid'] ?>">
                                    <i class="fa-solid fa-pen-to-square mr-2"></i>
                                    Modifier
                                </a>

                                <!-- Activer / Désactiver selon le statut -->
                                <?php if ($book['is_active'] == 1): ?>
                                    <a class="btn btn-outline-danger d-flex align-items-center w-100 mb-2"
                                    href="deactivate_book.php?book_uuid=<?= $book['book_uuid'] ?>">
                                        <i class="fa-solid fa-toggle-off mr-2"></i>
                                        Désactiver
                                    </a>
                                <?php else: ?>
                                    <a class="btn btn-outline-success d-flex align-items-center w-100 mb-2"
                                    href="activate_book.php?book_uuid=<?= $book['book_uuid'] ?>">
                                        <i class="fa-solid fa-toggle-on mr-2"></i>
                                        Activer
                                    </a>
                                <?php endif; ?>

                               
                            </div>
                        </div>
                    </td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" class="text-center">Aucune donnée disponible</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php if ($total_pages > 1): ?>
            <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                <div class="text-muted small">
                    Affichage de la page <strong><?= $current_page ?></strong> sur <strong><?= $total_pages ?></strong>
                </div>
                
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $current_page - 1 ?>">
                                <i class="fas fa-chevron-left"></i> Précédent
                            </a>
                        </li>

                        <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $current_page + 1 ?>">
                                Suivant <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
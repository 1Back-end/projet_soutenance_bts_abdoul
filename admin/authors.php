<?php include("../include/menu.php"); ?>
<?php include("../fonctions/fonction.php"); ?>

<div class="main-container pb-5 mt-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="h3 mb-0 text-gray-800 text-uppercase fw-bold">Liste des auteurs</h3>
            </div>
            <div class="ml-auto">
                <a href="add_author.php" class="btn shadow-none btn-primary fw-bold">
                    <i class="fas fa-plus-circle"></i> Ajouter un nouvel
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

        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Nationalité</th>
                        <th>Téléphone</th>
                        <th>Statut</th>
                        <th>Créer le</th>
                        <th>Dernière modif.</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($all_authors)): ?>
                        <?php foreach ($all_authors as $index => $author): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                
                               <td>
                                    <?php if (empty($author['author_picture'])): ?>
                                        <img src="../uploads/profile.jpeg" alt="Aucune photo" class='rounded-circle img-fluid mb-2' style='object-fit: cover; width: 60px; height: 60px;'>
                                    <?php else: ?>
                                        <img src="../uploads/<?= htmlspecialchars($author['author_picture']) ?>" 
                                            alt="Photo" class='rounded-circle img-fluid mb-2' style='object-fit: cover; width: 60px; height: 60px;'>
                                    <?php endif; ?>
                                    <div class="fw-bold text-uppercase"><?= htmlspecialchars($author['author_full_name']) ?></div>
                                </td>
                                <td><?= htmlspecialchars($author['author_email']) ?></td>
                                <td><?= htmlspecialchars($author['author_nationality']) ?></td>
                               <td>
                                    <i class="fa fa-phone text-primary mr-2"></i>
                                    <?= htmlspecialchars($author['author_phone_number']) ?>

                                    <?php if(!empty($author['author_second_phone_number'])): ?>
                                    <br>
                                    <i class="fa fa-phone text-secondary mr-2"></i>
                                    <?= htmlspecialchars($author['author_second_phone_number']) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= $author['is_active'] == 1 ? 'bg-success' : 'bg-danger' ?> text-white">
                                        <?= $author['is_active'] == 1 ? 'Actif' : 'Inactif' ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="text-primary fw-bold"><?= htmlspecialchars($author['creator_name'] ?? 'Système') ?></span><br>
                                    <small class="text-muted">le <?= date('d/m/Y à H:i', strtotime($author['created_at'])) ?></small>
                                </td>

                                <td>
                                    <?php if ($author['updated_at']): ?>
                                        <span class="text-primary fw-bold"><?= htmlspecialchars($author['editor_name'] ?? '') ?></span><br>
                                        <small class="text-muted">le <?= date('d/m/Y à H:i', strtotime($author['updated_at'])) ?></small>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                              <td>
                                <div class="dropdown">
                                    <button class="btn shadow-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>

                                    <div class="dropdown-menu p-2 shadow-lg">

                                        <a class="btn btn-outline-warning d-flex align-items-center w-100 mb-2"
                                        href="edit_author.php?author_uuid=<?= $author['author_uuid'] ?>">
                                            <i class="fa-solid fa-pen-to-square mr-2"></i>
                                            Modifier
                                        </a>

                                        <?php if ($author['is_active'] == 1): ?>
                                            <a class="btn btn-outline-danger d-flex align-items-center w-100 mb-2"
                                            href="deactivate_author.php?author_uuid=<?= $author['author_uuid'] ?>">
                                                <i class="fa-solid fa-toggle-off mr-2"></i>
                                                Désactiver
                                            </a>
                                        <?php else: ?>
                                            <a class="btn btn-outline-success d-flex align-items-center w-100 mb-2"
                                            href="activate_author.php?author_uuid=<?= $author['author_uuid'] ?>">
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
                            <td colspan="12" class="py-4 text-muted">Aucune donnée disponible.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
        </div>
    </div>
</div>



<?php include_once('../include/menu.php');?>


<?php include("../fonctions/fonction.php"); ?>

<div class="main-container pb-5 mt-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="h3 mb-0 text-gray-800 text-uppercase fw-bold">Liste des utilisateurs</h3>
            </div>
            <div class="ml-auto">
                <a href="add_users.php" class="btn shadow-none btn-primary fw-bold">
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
                    <i class="fas fa-check-circle me-1"></i> 
                    <?= htmlspecialchars($message); ?> !
                </span>
            <?php endif; ?>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-striped data-table" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom Complet</th>
                <th>Email</th>
                <th>Role</th>
                <th>Contact</th>
                <th>Statut</th>
                <th>Date création</th>
                <th>Dernière mise à jour</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($all_users as $index => $user): ?>

            <tr>

                <!-- Numérotation -->
                <td><?= ($index + 1) + (($current_page - 1) * $limit) ?></td>

                <td>
                    <?php if (empty($user['user_picture'])): ?>
                        <img src="../uploads/img_profile.png" alt="Aucune photo" class='rounded-circle img-fluid mb-2' style='object-fit: cover; width: 60px; height: 60px;'>
                    <?php else: ?>
                        <img src="../uploads/<?= htmlspecialchars($user['user_picture']) ?>" 
                        alt="Photo" class='rounded-circle img-fluid mb-2' style='object-fit: cover; width: 60px; height: 60px;'>
                    <?php endif; ?>
                    <div class="fw-bold text-uppercase"><?= htmlspecialchars($user['username']) ?></div>
                </td>

            
                <td>
                <div><?= htmlspecialchars($user["user_email"]) ?></div>

                <small class="text-muted">
                    Première connexion :
                    <?= !empty($user["first_connection_date"]) 
                        ? date('d-m-Y H:i', strtotime($user["first_connection_date"])) 
                        : '' ?>
                </small>

                <br>

                <small class="text-muted">
                    Dernière connexion :
                    <?= !empty($user["last_connection_date"]) 
                        ? date('d-m-Y H:i', strtotime($user["last_connection_date"])) 
                        : '' ?>
                </small>

                <br>
                <small class="text-muted">
                    Nombre de connexions : <?= isset($user["counter_connection"]) ? (int)$user["counter_connection"] : 0 ?>
                </small>

                </td>

                <td>
                    <span class="badge text-white 
                    <?= $user["user_role"] == 'system' ? 'bg-info' : ($user["user_role"] == 'admin' ? 'bg-success' : 'bg-secondary') ?>">
                    <?= $user["user_role"] == 'system' ? 'User système' : ($user["user_role"] == 'admin' ? 'User admin' : 'User') ?>
                    </span>
                </td>


                <td><?= htmlspecialchars($user["user_phone_number"]) ?></td>

                <td>
                    <span class="badge <?= $user['user_status'] == 'active' ? 'bg-success' : 'bg-danger' ?> text-white">
                        <?= $user['user_status'] == 'active' ? 'Actif' : 'Inactif' ?>
                    </span>
                </td>

                <td>
                    <span class="fw-bold"><?= htmlspecialchars($user['added_by_name'] ?? '') ?></span> à
                    <?= date('d-m-Y H:i:s', strtotime($user['created_at'])) ?>
               </td>

               <td>
                    <span class="fw-bold"><?= htmlspecialchars($user['updated_by_name'] ?? '') ?></span> à
                    <?= date('d-m-Y H:i:s', strtotime($user['updated_at'])) ?>
               </td>

                <td>
                <div class="dropdown">
                    <button class="btn shadow-none" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>

                    <div class="dropdown-menu p-2 shadow-lg">

                        <!-- Modifier -->
                        <a class="btn btn-outline-warning d-flex align-items-center w-100 mb-2"
                        href="edit_users.php?user_uuid=<?= $user['user_uuid'] ?>">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Modifier
                        </a>

                        <!-- Activer / Désactiver -->
                        <?php if ($user['user_status'] == 'active'): ?>
                            <a class="btn btn-outline-danger d-flex align-items-center w-100 mb-2"
                            href="deactivate_user.php?user_uuid=<?= $user['user_uuid'] ?>">
                                <i class="fa-solid fa-toggle-off me-2"></i>
                                Désactiver
                            </a>
                        <?php else: ?>
                            <a class="btn btn-outline-success d-flex align-items-center w-100 mb-2"
                            href="activate_user.php?user_uuid=<?= $user['user_uuid'] ?>">
                                <i class="fa-solid fa-toggle-on me-2"></i>
                                Activer
                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            </td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>
    <nav class="mt-3 d-flex justify-content-between align-items-center">

        <!-- Info page à gauche -->
        <div>
            Page <?= $current_page ?> sur <?= $total_pages ?>
        </div>

        <!-- Boutons précédent / suivant à droite -->
        <ul class="pagination mb-0 pagination-sm">

            <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $current_page - 1 ?>">Précédent</a>
                </li>
            <?php endif; ?>

            <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $current_page + 1 ?>">Suivant</a>
                </li>
            <?php endif; ?>

        </ul>

    </nav>
    </div>
    </div>

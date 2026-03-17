

<section id="featured-courses" class="featured-courses section"> 

  <div class="container section-title" data-aos="fade-up">
      <h2>Ouvrages en Vedette</h2>
      <p>Explorez une sélection de livres populaires, récemment ajoutés ou les plus empruntés par nos lecteurs.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
          <?php foreach ($all_books as $index => $book): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= 200 + ($index*100) ?>">
              <div class="course-card">
                  <div class="course-image position-relative">
                      <img src="../uploads/<?= htmlspecialchars($book['book_picture'] ?: '../public/assets/img/book-1.png') ?>" 
                           alt="<?= htmlspecialchars($book['book_name']) ?>" class="img-fluid">

                      <!-- Badge disponibilité -->
                      <?php if ($book['is_active']): ?>
                          <div class="badge featured">Disponible</div>
                      <?php else: ?>
                          <div class="badge popular">Indisponible</div>
                      <?php endif; ?>

                      <!-- Badge pages / exemplaires -->
                      <div class="price-badge">
                          <?php if (!empty($book['book_copies'])): ?>
                              <?= htmlspecialchars($book['book_copies']) ?> exemplaires
                          <?php endif; ?>
                      </div>
                  </div>

                  <div class="course-content">
                      <div class="course-meta">
                          <span class="level">Catégorie : <?= htmlspecialchars($book['category_name']) ?></span>
                          <span class="duration">Publié en <?= htmlspecialchars($book['book_publication_date']) ?></span>
                      </div>

                      <h3><a href="#"><?= htmlspecialchars($book['book_name']) ?></a></h3>
                      <p class="text-truncate"><?= htmlspecialchars($book['book_description']) ?></p>

                      <div class="instructor">
                         <img src="../uploads/<?= htmlspecialchars($book['author_picture'] ?? '../assets/vendors/images/authors.png') ?>" 
                          alt="Auteur" class="instructor-img">
                          <div class="instructor-info">
                              <h6><?= htmlspecialchars($book['author_full_name']) ?></h6>
                              <span>Auteur</span>
                          </div>
                      </div>
                      
                      <?php if (isUserLoggedIn()): ?>
                          <a href="emprunter.php?book_uuid=<?= $book['book_uuid'] ?>" class="btn-course">Emprunter</a>
                      <?php else: ?>
                          <a href="javascript:void(0);" class="btn-course" data-bs-toggle="modal" data-bs-target="#loginModal">Emprunter</a>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
          <?php endforeach; ?>
      </div>

      <div class="more-courses text-center" data-aos="fade-up" data-aos-delay="500">
          <a href="livres.html" class="btn-more">Voir Livres</a>
      </div>
  </div>
</section>



<!-- Modal connexion / inscription -->
<div class="modal fade" id="loginModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Connexion requise</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p>Pour emprunter un livre, vous devez être connecté.</p>
        <div class="d-flex gap-2 justify-content-center">
          <a href="connexion.html" class="btn btn-primary d-flex align-items-center">
            <i class="fas fa-sign-in-alt me-2"></i> Se connecter
          </a>
          <a href="inscription.html" class="btn btn-outline-primary d-flex align-items-center">
            <i class="fas fa-user-plus me-2"></i> Créer un compte
          </a>
        </div>
      </div>
    </div>
  </div>
</div>